<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('profile_pic')->nullable();
            $table->enum('role', ['Super Admin', 'Admin'])->default('Admin');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('admin_capabilities', function (Blueprint $table) {
            $table->id();
            $table->uuid('admin_id');
            $table->string('capability'); // e.g., 'view', 'edit', 'delete'
            $table->string('module');     // e.g., 'appointments', 'pets', 'services'
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });

        Schema::create('admin_page_access', function (Blueprint $table) {
            $table->id();
            $table->uuid('admin_id');
            $table->string('page'); // e.g., 'dashboard', 'appointments', 'services'
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_page_access');
        Schema::dropIfExists('admin_capabilities');
        Schema::dropIfExists('admins');
    }
};
