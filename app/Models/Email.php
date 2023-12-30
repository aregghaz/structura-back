<?php

namespace App\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'recipient_id',
        'subject',
        'body',
        'folder_id',
        'owner_id',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function statuses()
    {
        return $this->hasMany(EmailStatus::class);
    }
    public static function findOrFail($id, $columns = ['*'])
    {
        if (is_array($id) || $id instanceof Arrayable) {
            return static::query()->findOrFail($id, $columns);
        }

        return static::query()->whereKey($id)->firstOrFail($columns);
    }
}
