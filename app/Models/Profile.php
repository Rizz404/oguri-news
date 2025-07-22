<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Profile extends Model
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'user_id',
        'age',
        'bio',
        'fullname',
        'phone_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
