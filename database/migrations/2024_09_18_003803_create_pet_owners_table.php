<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetOwnersTable extends Migration
{
    public function up()
    {
        Schema::create('pet_owners', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('google_id')->nullable()->unique();
            $table->string('Fname');
            $table->string('Lname')->nullable();
            $table->string('Mname')->nullable();
            $table->string('email')->unique()->index();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('password')->nullable();
            $table->integer('no_pets')->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->string('profile_pic')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('pet_owners');
    }
}
