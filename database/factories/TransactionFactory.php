<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Transaction;
use App\Models\User;
use Faker\Generator as Faker;


$factory->define(Transaction::class, function (Faker $faker) {
    $usersAccounts = User::all()
        ->map(function (User $user) {
            return [
                'id' => $user->id,
                'balance' => $user->account->balance
            ];
        })
        ->pluck('balance', 'id')
        ->toArray();

    $somebodyHasMoney = false;
    foreach ($usersAccounts as $account) {
        if ($account > 0) {
            $somebodyHasMoney = true;
            break;
        }
    }
    if (!$somebodyHasMoney) {
        throw new \Exception('There is no user with money, so it is impossible to create transaction');
    }

    $balance = 0;
    $key = 0;
    while ($balance == 0) {
        $sender_id = array_rand($usersAccounts);
        $balance = $usersAccounts[$sender_id];
    }
    unset($usersAccounts[$key]);

    $recipient_id = array_rand($usersAccounts);

    return [
        'sender_id' => $sender_id,
        'recipient_id' => $recipient_id,
        'amount' => $faker->randomFloat(2, 0.01, User::find($sender_id)->account->balance),
        'sending_date' => $faker->dateTimeBetween('now', '+7 days')->format('Y-m-d h:00'),
        'sent_date' => null,
    ];
});
