<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use App\Genre;
use App\Page;
use App\Rating;
use App\System;
use Auth;
use IGDB;
use Illuminate\Http\Request;
use Image;
use Storage;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkadmin')->only(['create', 'edit', 'store', 'update']);
    }

    public function achievements($id)
    {
        $game = Game::where('slug', $id)->first();

        return view('game.achievements', ['game' => $game]);
    }

    public function addToWishlist(Request $request)
    {
        if (Auth::check())
        {
            Auth::user()->addToWishlist($request->id);
        } else {
            $request->session()->flash('danger', 'You need to login to add a game to your wishlist!');
            return redirect()->route('login');
        }
        $game = Game::find($request->id);

        return redirect()->route('game.show', $game->slug);
    }

    public function create()
    {
        $categories = Category::all()->pluck('name', 'id');
        $ratings    = Rating::all()->pluck('name', 'id');
        $systems    = System::all()->pluck('name', 'id');

        return view('game.form', ['categories' => $categories, 'ratings' => $ratings, 'systems' => $systems]);
    }

    public function deleteFromWishlist(Request $request)
    {
        if(Auth::check())
        {
            Auth::user()->deleteFromWishlist($request->id);
        } else {
            $request->session()->flash('success', 'You need to login to delete a game to your wishlist!');
            return redirect()->route('login');
        }
        $game = Game::find($request->id);

        return redirect()->route('game.show', $game->slug);
    }

    public function edit($id)
    {
        $categories = Category::all()->pluck('name', 'id');
        $ratings    = Rating::all()->pluck('name', 'id');
        $systems    = System::all()->pluck('name', 'id');
        $game       = Game::find($id);

        return view('game.form', ['game' => $game, 'categories' => $categories, 'ratings' => $ratings, 'systems' => $systems]);

    }

    public function homepage()
    {
        $xboxonecount = Game::where('system_id', 4920)->count();
        $ps4count = Game::where('system_id', 4919)->count();
        
        $xboxone = Game::where('system_id', 4920)->get()->random(min(4, $xboxonecount));
        $ps4     = Game::where('system_id', 4919)->get()->random(min(4, $ps4count));

        return view('home', ['xboxone' => $xboxone, 'ps4' => $ps4]);
    }

    public function index()
    {
        $games = Game::paginate(4);

        $systems = System::all()->pluck('name', 'url');
        $categories = Category::all()->pluck('name', 'url');
        $rating = Rating::all()->pluck('name', 'name');
        $genres = Genre::all()->pluck('name', 'id');
        $premium = ['yes' => 'Only Premium', 'no' => 'Only Standard'];

        return view('game.index', ['genres' => $genres, 'games' => $games, 'systems' => $systems, 'ratings' => $rating, 'premium' => $premium, 'categories' => $categories]);
    }

    public function search(Request $request)
    {
        $getString = str_replace('/search-games/', '', $request->getPathInfo());

        $getArray = explode('~~', $getString);
        $getArray = array_filter($getArray);

        $where = array();

        if ($request->category_id)
        {
            $sqlvalue = Category::where('url', $request->category_id)->first();
            if ($sqlvalue)
            {
                $where[] = ['category_id', '=', $sqlvalue->id];
            }
        }

        if ($request->is_premium)
        {
            if ($request->is_premium == 'yes')
            {
                $where[] = ['is_premium', '=', 1];
            } else {
                $where[] = ['is_premium', '=', 0];
            }
        }

        if ($request->name)
        {
            $where[] = ['name', 'like', '%'.$request->name.'%'];
        }

        if ($request->num_available)
        {
            $where[] = ['num_available', '>', 0];
        }

        if ($request->rating_id)
        {
            $where[] = ['pegi_rating', '=', $request->rating_id];
        }

        if ($request->system_id)
        {
            $sqlvalue = System::where('url', $request->system_id)->first();
            if ($sqlvalue)
            {
                $where[] = ['system_id', '=', $sqlvalue->id];
            }
        }

        //dd($where);

        if ($request->genre_id)
        {
            $genre = Genre::where('slug', $request->genre_id)->first();
            $games = Game::genre($genre->id)->where($where)->paginate(20);
        } else {
            $games = Game::where($where)->paginate(20);
        }

        $systems = System::has('games')->pluck('name', 'url');
        $categories = Category::all()->pluck('name', 'url');
        $genres = Genre::orderby('name')->pluck('name', 'slug');
        $rating = Rating::all()->pluck('name', 'id');
        $premium = ['yes' => 'Only Premium', 'no' => 'Only Standard'];

        return view('game.index', ['games' => $games, 'genres' => $genres, 'systems' => $systems, 'ratings' => $rating, 'premium' => $premium, 'categories' => $categories]);
    }

    public function show($id)
    {
        $game = Game::where('slug', $id)->first();

        //Synchronise with PageController@show. TODO: This is probably dumb. Must be a better way?
        if (!$game)
        {
            $page = Page::where('slug', 'rent-'.$id)->first();

            if (!$page) abort(404, 'Page not found');

            return view('page.show', ['page' => $page]);
        }

        return view('game.show', ['game' => $game]);
    }

    public function store(Request $request)
    {
        if (!$request->gamesdb_id)
        {
            //Then we need to show to the user the list of IDs. 
            $api = IGDB::searchGames($request->name);
            foreach ($api as $game)
            {
                $errors[] = $game->id.' - '.$game->name.'<br />';
            }

            if (count($errors))
            {
                $request->session()->flash('success', implode($errors, "\n"));

                return redirect()->route('game.create');
            }
        }

        $request->validate([
            'system_id' => 'required',
            'gamesdb_id' => 'required',
        ]);

        //Now we need to check that there's no existing game with this ID. 
        $existingGames = Game::where('system_id', $request->system_id)->where('gamesdb_id', $request->gamesdb_id);
        if ($existingGames->count())
        {
            session()->flash('danger', 'This combination of SystemID and IGDB ID already exists. You probably want to edit this game.');
            return redirect()->route('game.edit', $existingGames->first()->id);
        }

        $game = Game::create($request->all());

        if(isset($request->picture))
        {
            $game->picture_url = $request->picture->store('games_boxes', 'public');
            $game->thumb_url   = $request->picture->store('games_thumbs', 'public');
        }
        $game->save();
        $game->refreshInfo();

        $request->session()->flash('success', 'The game has successfully been added, <a target="_blank" href="'.route('game.show', $game->slug).'">click here to see it</a>!');

        return redirect()->route('game.create');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'system_id' => 'required',
            'gamesdb_id' => 'required',
        ]);

        //Now we need to check that there's no existing game with this ID. 
        $existingGames = Game::where('system_id', $request->system_id)->where('gamesdb_id', $request->gamesdb_id)->where('id', '<>', $id);
        if ($existingGames->count())
        {
            session()->flash('danger', 'This combination of SystemID and IGDB ID already exists. You probably want to edit this game.');
            return redirect()->route('game.edit', $existingGames->first()->id);
        }

        $game = Game::find($id);

        $game->update($request->all());

        if(isset($request->picture))
        {
            $game->picture_url = $request->picture->store('games_boxes', 'public');
            $game->thumb_url   = $request->picture->store('games_thumbs', 'public');
        }

        $game->save();
        $errors = $game->refreshInfo();

        if (count($errors))
        {
            $request->session()->flash('success', implode($errors, "\n"));

            return redirect()->route('game.edit', $id);
        }

        $request->session()->flash('success', 'The game has successfully been edited, <a href="'.route('game.show', $game->slug).'">click here to see it</a>! Alternatively you can <a href="'.route('game.create').'">create a new game</a>.)');

        return redirect()->route('game.edit', $id);
    }
}
