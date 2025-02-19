<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Adiciona colunas à tabela tenants existente
        Schema::table('tenants', function (Blueprint $table) {
            // Adiciona as novas colunas após 'id'
            $table->string('name')->nullable()->after('id');
            $table->string('company_name')->nullable()->after('name');
            $table->string('cnpj', 14)->nullable()->unique()->after('company_name');
            $table->string('zip_code', 8)->nullable()->after('cnpj');
            $table->string('address')->nullable()->after('zip_code');
            $table->string('number')->nullable()->after('address');
            $table->string('complement')->nullable()->after('number');
            $table->string('neighborhood')->nullable()->after('complement');
            $table->string('city')->nullable()->after('neighborhood');
            $table->string('state', 2)->nullable()->after('city');
            $table->string('phone')->nullable()->after('state');
            $table->string('email')->nullable()->after('phone');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('email');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            // Remove as colunas adicionadas
            $table->dropColumn([
                'name',
                'company_name',
                'cnpj',
                'zip_code',
                'address',
                'number',
                'complement',
                'neighborhood',
                'city',
                'state',
                'phone',
                'email',
                'status',
                'deleted_at'
            ]);
        });
    }
};