<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'surname',
        'fatherName',
        'country',
        'passport',
        'password',
        'dob',
        'email',
        'status',
    ];
    public function sentEmails()
    {
        return $this->hasMany(Email::class, 'sender_id');
    }

    public function receivedEmails()
    {
        return $this->hasMany(Email::class, 'recipient_id');
    }

    public function emailStatuses()
    {
        return $this->hasMany(EmailStatus::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public static function findOrFail($id, $columns = ['*'])
    {
        if (is_array($id) || $id instanceof Arrayable) {
            return static::query()->findOrFail($id, $columns);
        }

        return static::query()->whereKey($id)->firstOrFail($columns);
    }
}
