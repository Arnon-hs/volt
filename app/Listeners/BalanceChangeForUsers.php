<?php

namespace App\Listeners;

use App\Events\ChangePriceAtTheClient;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BalanceChangeForUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  ChangePriceAtTheClient  $event
     * @return void
     */
    public function handle(ChangePriceAtTheClient $event)
    {
        //todo
    }
}
