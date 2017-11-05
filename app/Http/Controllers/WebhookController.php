<?php

namespace App\Http\Controllers;

use Braintree\WebhookNotification;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    /**
     * Handle a Braintree webhook.
     *
     * @param  WebhookNotification  $webhook
     * @return Response
     */
    public function handleWebhook(WebhookNotification $notification)
    {
        $user = User::find(1);
        Mail::to($user)->send(new BraintreeDebug($notification));
    }
}