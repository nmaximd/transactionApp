<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        if(is_null($user->account)) {
            $user->account()->create(['balance' => 0]);
        }
    }
}
