<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';
    const CREATED_AT = 'creationDate';
    const UPDATED_AT = null;


    protected $fillable = ['message', 'userId', 'id_guild', 'creationDate'];
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'userId', 'id_utilisateur');
    }


    public function guild()
    {
        return $this->belongsTo(ListGuild::class, 'id_guild', 'id_guild');
    }
    public function listGuild()
    {
        return $this->belongsTo(ListGuild::class, 'id_guild', 'id_guild');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'userId', 'id_utilisateur');
    }
    public function message()
    {
        return $this->hasMany(Message::class, 'id_guild', 'id_guild');
    }



}

