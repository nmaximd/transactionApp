<?php

namespace App\Models;

use App\Exceptions\TransactionStatusNotFoundException;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * @inheritdoc
     */
    protected $fillable = [
        'sender_id',
        'recipient_id',
        'amount',
        'sending_date',
        'sent_date',
        'status'
    ];

    /**
     * Available statuses
     */
    const STATUS_PLANNED = 0;
    const STATUS_PROCESSED = 1;
    const STATUS_USER_ERROR = 2;
    const STATUS_SERVER_ERROR = 3;

    private static $labels = [
        self::STATUS_PLANNED => 'Planned',
        self::STATUS_PROCESSED => 'Processed',
        self::STATUS_USER_ERROR => 'User error',
        self::STATUS_SERVER_ERROR => 'Server error',
    ];

    /**
     * Get label by status value
     * @param int $status
     * @return string
     * @throws TransactionStatusNotFoundException
     */
    public static function getStatusLabel(int $status)
    {
        if (!isset(self::$labels[$status])) {
            throw new TransactionStatusNotFoundException('Transaction status ' . $status . ' not found.');
        } else {
            return self::$labels[$status];
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(User::class);
    }
}
