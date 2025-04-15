<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID as primary key
            $table->uuid('pet_id');
            $table->string('pet_type');
            $table->date('record_date');
            $table->text('description');
            $table->text('tx_given')->nullable();
            $table->json('prescription');
            $table->uuid('vet_id');
            $table->foreign('vet_id')->references('id')->on('admin_users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
