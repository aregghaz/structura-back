<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEmail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'email_id',
        'status',
        'user_status',
    ];

    public function users() {
        return $this->hasOne(User::class,'id','user_id');

    }
}
