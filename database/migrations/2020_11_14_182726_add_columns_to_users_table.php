<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf')->unique()->comment('CPF do usuário');
            $table->date('yearbirth')->nullable()->comment('data de nascimento do usuario');
            $table->string('adress')->nullable()->comment('Endereço do usuário');;
            $table->unsignedInteger('certificate_id')->nullable()->comment('Chave estrangeira do certificado do usuário');

            $table->foreign('certificate_id')->references('id')->on('certificates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cpf']);
            $table->dropColumn(['yearbirth']);
            $table->dropColumn(['adress']);
            $table->dropColumn(['certificate_id']);
        });
    }
}
