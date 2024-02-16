<?php


namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;
    protected $table = 'utilisateurs';

    protected $fillable = ['id','id_utilisateur', 'pseudo', 'score', 'email', 'password', 'active', 'role','email_verified_at','email_verification_token'];
    public $timestamps = false;

    // Vous pouvez ajouter ici des méthodes pour les relations, si nécessaire
}
