<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;


class Subscriber extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'national_id',
        'user_id',
    ];


    //.إلى النظام Subscriber المستخدم الذي أضاف هذا
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    //Subscriber أرقام الهاتف التابعة لهذا
    // public function phoneNumbers(): HasMany
    // {
    //     return $this->hasMany(PhoneNumber::class);
    // }
}
