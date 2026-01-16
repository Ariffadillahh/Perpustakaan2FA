<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('password');

            // TAMBAHKAN INI (Wajib untuk User Laravel)
            $table->rememberToken();

            // 2FA
            $table->text('google2fa_secret')->nullable();
            $table->boolean('two_factor_enabled')->default(false);

            // RBAC
            $table->foreignId('role_id')
                ->constrained('roles')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
