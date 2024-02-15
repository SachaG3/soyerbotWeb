<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageDelete extends Model
{
    protected $table = 'message_delete';
    protected $fillable = ['message', 'userId', 'creationDate'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
