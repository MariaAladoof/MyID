<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;


class Subscriber extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'national_id',
        'user_id',
    ];

    // المستخدم الذي أضاف المشترك إلى النظام
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // سجلات ملكية الأرقام الخاصة بهذا المشترك
    public function ownerships(): HasMany
    {
        return $this->hasMany(PhoneNumberOwnership::class);
    }

    //Subscriber أرقام الهاتف التابعة لهذا
    // public function phoneNumbers(): HasMany
    // {
    //     return $this->hasMany(PhoneNumber::class);
    // }
}
