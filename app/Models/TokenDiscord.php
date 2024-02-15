<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenDiscord extends Model
{
    protected $table = 'token_discord';

    // Assurez-vous de définir $fillable avec tous les champs que vous allez assigner massivement
    protected $fillable = ['token', 'id_utilisateur', 'date_creation'];

    public $timestamps = false; // Définissez sur false si votre table n'a pas les colonnes created_at et updated_at

    // Si vous avez une relation avec une autre table, par exemple avec 'utilisateurs', vous pouvez ajouter une méthode de relation
    public function utilisateur()
    {
        // Remplacez 'Utilisateur' par le nom de classe réel de votre modèle Utilisateur
        // et 'id_utilisateur' par la clé étrangère dans la table 'token_discord' si elle est différente
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }
}
