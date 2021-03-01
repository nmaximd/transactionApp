<?php

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 100)->withoutEvents()->create()->each(function (User $user) {
            $user->account()->save(factory(Account::class)->make());
        });
    }
}
