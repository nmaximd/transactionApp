<?php

namespace App\Models;

use App\Exceptions\AccountBalanceNotEnough;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * @inheritdoc
     */
    protected $primaryKey = 'user_id';

    /**
     * @inheritdoc
     */
    public $timestamps = false;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:2'
    ];

    /**
     * Account owner
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param float $amount
     * @throws AccountBalanceNotEnough
     * @return Account
     */
    public function decreaseBalance(float $amount)
    {
        if ($this->balance < $amount){
            throw new AccountBalanceNotEnough("There is not enough money on the balance [$this->user_id]");
        } else {
            $this->update(['balance' => $this->balance - $amount]);
        }
        return $this;
    }

    /**
     * @param float $amount
     * @return Account
     */
    public function increaseBalance(float $amount)
    {
        $this->update(['balance' => $this->balance + $amount]);
        return $this;
    }
}
