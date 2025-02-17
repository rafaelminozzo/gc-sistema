<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('franchises', function (Blueprint $table) {
            $table->string('id')->primary(); // Será usado como identificador do tenant
            $table->string('name');
            $table->string('company_name');
            $table->string('cnpj', 14)->unique();
            $table->string('address');
            $table->string('city');
            $table->string('state', 2);
            $table->string('zip_code', 8);
            $table->string('phone');
            $table->string('email');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('franchises');
    }
};
