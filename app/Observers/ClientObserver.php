<?php

namespace App\Observers;

use App\Models\Client;
use App\Models\ClientHistory;
use Illuminate\Support\Facades\Auth;

class ClientObserver
{
    /**
     * Handle the Client "created" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function created(Client $client)
    {
        $history = new ClientHistory();
        $history->client_id = $client->id;
        $history->action = "criado";
        $history->trade_status = $client->trade_status;
        $history->user_id = Auth::user()->id;
        $history->subsidiary_id = $client->subsidiary_id;
        $history->saveQuietly();
    }

    /**
     * Handle the Client "updated" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function updated(Client $client)
    {
        $history = new ClientHistory();
        $history->client_id = $client->id;
        $history->action = "editado";
        $history->trade_status = $client->trade_status;
        $history->user_id = Auth::user()->id;
        $history->subsidiary_id = $client->subsidiary_id;
        $history->saveQuietly();
    }

    /**
     * Handle the Client "deleted" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function deleted(Client $client)
    {
        $history = new ClientHistory();
        $history->client_id = $client->id;
        $history->action = "deletado";
        $history->trade_status = $client->trade_status;
        $history->user_id = Auth::user()->id;
        $history->subsidiary_id = $client->subsidiary_id;
        $history->saveQuietly();
    }

    /**
     * Handle the Client "restored" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function restored(Client $client)
    {
        $history = new ClientHistory();
        $history->client_id = $client->id;
        $history->action = "restaurado";
        $history->trade_status = $client->trade_status;
        $history->user_id = Auth::user()->id;
        $history->subsidiary_id = $client->subsidiary_id;
        $history->saveQuietly();
    }

    /**
     * Handle the Client "force deleted" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function forceDeleted(Client $client)
    {
        $history = new ClientHistory();
        $history->client_id = $client->id;
        $history->action = "deletado forçadamente";
        $history->trade_status = $client->trade_status;
        $history->user_id = Auth::user()->id;
        $history->subsidiary_id = $client->subsidiary_id;
        $history->saveQuietly();
    }
}
