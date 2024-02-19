<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketResponsesTable extends Migration
{
    public function up()
    {
        Schema::create('ticket_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('support_tickets')->onUpdate('cascade')->onDelete('cascade'); // un lien vers le ticket support
            $table->text('content');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->nullable(); // date de la dernière modification
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_responses');
    }
}
