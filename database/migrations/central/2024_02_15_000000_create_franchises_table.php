<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->string('company_name')->nullable()->after('name');
            $table->string('cnpj', 14)->nullable()->unique()->after('company_name');
            $table->string('address')->nullable()->after('cnpj');
            $table->string('city')->nullable()->after('address');
            $table->string('state', 2)->nullable()->after('city');
            $table->string('zip_code', 8)->nullable()->after('state');
            $table->string('phone')->nullable()->after('zip_code');
            $table->string('email')->nullable()->after('phone');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('email');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'company_name',
                'cnpj',
                'address',
                'city',
                'state',
                'zip_code',
                'phone',
                'email',
                'status',
                'deleted_at'
            ]);
        });
    }
};