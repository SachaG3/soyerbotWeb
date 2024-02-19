<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'image_path',
    ];

    // Dans MessageImage.php
    public function response()
    {
        return $this->belongsTo(TicketResponse::class, 'message_id');
    }

}