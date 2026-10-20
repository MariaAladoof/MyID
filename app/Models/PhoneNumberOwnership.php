<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhoneNumberOwnership extends Model
{
    protected $fillable = [
        'subscriber_id',
        'phone_number_id',
        'started_at',
        'ended_at',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    public function phoneNumber(): BelongsTo
    {
        return $this->belongsTo(PhoneNumber::class);
    }


    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class)->withTrashed();
    }
}
