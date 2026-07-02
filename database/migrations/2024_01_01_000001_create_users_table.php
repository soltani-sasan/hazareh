<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email', 180)->unique()->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('national_id', 10)->unique()->nullable();
            $table->string('password');
            $table->enum('role', ['admin','student','teacher','counselor','judge','conference_admin','visitor'])
                  ->default('visitor');
            $table->string('avatar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
        
    }
};
