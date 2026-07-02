<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conference', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('اولین همایش بین‌المللی هنرستان‌های جوار صنعت');
            $table->longText('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('submission_deadline')->nullable();
            $table->string('venue')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('conference_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('full_name', 120);
            $table->string('national_id', 10)->nullable();
            $table->string('organization', 150)->nullable();
            $table->string('email', 180)->nullable();
            $table->string('phone', 15)->nullable();
            $table->enum('participant_type', ['student','teacher','industry','public','other'])->default('public');
            $table->enum('status', ['pending','confirmed','rejected'])->default('pending');
            $table->timestamps();
        });

        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('abstract');
            $table->string('keywords')->nullable();
            $table->enum('track', ['instrumentation','mechanical','electrical','innovation']);
            $table->string('file_path')->nullable();
            $table->enum('status', ['submitted','under_review','accepted','rejected','revision'])->default('submitted');
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();            
        });

        Schema::create('paper_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paper_id')->constrained('papers')->cascadeOnDelete();
            $table->foreignId('judge_id')->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('originality')->nullable();
            $table->tinyInteger('quality')->nullable();
            $table->tinyInteger('relevance')->nullable();
            $table->tinyInteger('presentation')->nullable();
            $table->decimal('total_score', 4, 1)->nullable();
            $table->text('comments')->nullable();
            $table->enum('decision', ['accept','reject','revision'])->nullable();
            $table->timestamp('reviewed_at')->useCurrent();
            $table->timestamps();
        });

        Schema::create('judges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->nullOnDelete();
            $table->string('name', 120);
            $table->string('title')->nullable();
            $table->string('organization')->nullable();
            $table->enum('track', ['instrumentation','mechanical','electrical','innovation','all'])->default('all');
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
        });

        Schema::create('conference_partners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('logo')->nullable();
            $table->enum('type', ['university','industry','gov'])->default('industry');
            $table->tinyInteger('sort_order')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conference_partners');
        Schema::dropIfExists('judges');
        Schema::dropIfExists('paper_reviews');
        Schema::dropIfExists('papers');
        Schema::dropIfExists('conference_registrations');
        Schema::dropIfExists('conference');
    }
};
