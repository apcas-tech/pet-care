<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            // Unique 16-character ID
            $table->char('id', 36)->primary();

            // Basic user information
            $table->string('Fname');
            $table->string('Lname');
            $table->string('Mname')->nullable();
            $table->string('email')->unique();
            $table->string('password');

            // Role and permissions
            $table->enum('role', ['Super Admin', 'Admin', 'Vet']);
            $table->json('capabilities')->nullable(); // Store Edit, Delete, View capabilities as JSON
            $table->json('pages')->nullable(); // Store accessible pages (e.g., 'appointments', 'services')
            $table->uuid('branch_id')->nullable(); // Ensure this matches the type in vet_contacts
            $table->foreign('branch_id')->references('id')->on('vet_contacts')->onDelete('set null');
            $table->string('profile_pic')->nullable();
            // Timestamps for created_at and updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
