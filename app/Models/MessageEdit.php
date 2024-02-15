<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageEdit extends Model
{
    protected $table = 'message_edit';
    protected $fillable = ['message', 'userId', 'creationDate', 'new_message'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
