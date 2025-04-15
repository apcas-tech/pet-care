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
        Schema::create('adoptable_pets', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('name');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('species');
            $table->string('breed');
            $table->decimal('weight', 5, 2);
            $table->date('bday');
            $table->text('remarks')->nullable();
            $table->string('profile_pic')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoptable_pets');
    }
};
