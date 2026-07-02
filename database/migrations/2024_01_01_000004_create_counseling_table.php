<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counseling_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('sender_type', ['student','parent']);
            $table->string('full_name', 120);
            $table->string('national_id', 10);
            $table->string('parent_name', 120)->nullable();
            $table->string('home_phone', 15)->nullable();
            $table->string('mobile', 15);
            $table->string('email', 180)->nullable();
            $table->enum('reply_via', ['sms','email'])->default('email');
            $table->string('subject');
            $table->boolean('is_private')->default(true);
            $table->text('message');
            $table->enum('status', ['pending','answered'])->default('pending');
            $table->foreignId('responder_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('response_text')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['national_id', 'mobile']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counseling_requests');
    }
};
