<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->string('id', 16)->primary();
            $table->string('pet_id', 36);
            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
            $table->string('owner_id', 36);
            $table->foreign('owner_id')->references('id')->on('pet_owners')->onDelete('cascade');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->uuid('branch_id')->nullable(); // Ensure this matches the type in vet_contacts
            $table->foreign('branch_id')->references('id')->on('vet_contacts')->onDelete('set null');
            $table->date('appt_date');
            $table->time('appt_time');
            $table->enum('status', ['Pending', 'Scheduled', 'Completed', 'Cancelled']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
