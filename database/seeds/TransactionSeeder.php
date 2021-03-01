<?php

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * for is used to prevent
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i<100; $i++){
            factory(Transaction::class)->create();
        }
    }
}
