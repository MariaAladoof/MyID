<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    // شركة الاتصالات التي يتبع لها الرقم
    public function telecomOperator(): BelongsTo
    {
        return $this->belongsTo(TelecomOperator::class);
    }

    // جميع سجلات ملكية هذا الرقم عبر الزمن
    public function ownerships(): HasMany
    {
        return $this->hasMany(PhoneNumberOwnership::class);
    }

    // سجل الملكية الحالي، إن وجد
    public function currentOwnership(): HasOne
    {
        return $this->hasOne(PhoneNumberOwnership::class)
            ->whereNull('ended_at');
    }
}
