<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('owner_id', 36);
            $table->foreign('owner_id')->references('id')->on('pet_owners')->onDelete('cascade');
            $table->string('name');
            $table->float('weight');
            $table->string('species');
            $table->string('breed');
            $table->date('bday');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('special_char')->nullable();
            $table->string('profile_pic')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pets');
    }
}
