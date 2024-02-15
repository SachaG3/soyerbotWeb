<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListGuild extends Model
{
    protected $table = 'list_guild';
    public $timestamps = false; // Pas de timestamps dans cette table
    protected $fillable = ['id_guild', 'name_guild'];
}
