<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            $table->timestamp('email_verified_at')->nullable(); // la date d'émail véréfiée
            $table->string('email_verification_token', 64)->nullable(); //le token de vérfication d'émail
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');
            $table->dropColumn('email_verification_token');
        });
    }
};
