<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'status',
        'public',
    ];

    public function user()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function responses()
    {
        return $this->hasMany(TicketResponse::class, 'ticket_id');
    }
}