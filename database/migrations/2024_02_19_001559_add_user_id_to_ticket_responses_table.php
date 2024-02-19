<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToTicketResponsesTable extends Migration
{
    public function up()
    {
        Schema::table('ticket_responses', function (Blueprint $table) {
            $table->integer('user_id')->index();
            $table->foreign('user_id')->references('id')->on('utilisateurs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('ticket_responses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
