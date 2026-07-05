<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->nullOnDelete();
            $table->string('student_code', 20)->unique()->nullable();
            $table->enum('grade', ['10','11','12'])->default('10');
            $table->enum('field', ['electrical','mechanical','instrumentation']);
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('father_name', 80)->nullable();
            $table->string('father_phone', 15)->nullable();
            $table->string('mother_name', 80)->nullable();
            $table->string('mother_lastname', 80)->nullable();
            $table->string('mother_phone', 15)->nullable();
            $table->string('prev_school', 120)->nullable();
            $table->unsignedTinyInteger('prev_district')->nullable();
            $table->string('prev_principal', 80)->nullable();
            $table->string('prev_counselor', 80)->nullable();
            $table->decimal('last_gpa', 4, 2)->nullable();
            $table->decimal('discipline_score', 4, 2)->nullable();
            $table->string('photo_path')->nullable();
            $table->string('guidance_doc_path')->nullable();
            $table->enum('enrollment_status', ['pending','accepted','rejected','waiting'])->default('pending');
            $table->text('enrollment_note')->nullable();
        });

        Schema::create('pre_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('national_id', 10);
            $table->string('first_name', 80);
            $table->string('last_name', 80);
            $table->date('birth_date')->nullable();
            $table->string('home_phone', 15)->nullable();
            $table->string('mobile', 15);
            $table->string('introducer_name', 120)->nullable();
            $table->string('father_name', 80)->nullable();
            $table->string('father_mobile', 15)->nullable();
            $table->string('mother_name', 80)->nullable();
            $table->string('mother_lastname', 80)->nullable();
            $table->string('mother_mobile', 15)->nullable();
            $table->string('prev_school', 120)->nullable();
            $table->unsignedTinyInteger('prev_district')->nullable();
            $table->string('prev_principal', 80)->nullable();
            $table->string('prev_counselor', 80)->nullable();
            $table->decimal('last_gpa', 4, 2)->nullable();
            $table->decimal('discipline_score', 4, 2)->nullable();
            $table->enum('requested_field', ['electrical','mechanical','instrumentation']);
            $table->string('how_known')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('guidance_doc')->nullable();
            $table->enum('status', ['pending','reviewed','accepted','rejected'])->default('pending');
            $table->text('admin_note')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pre_registrations');
        Schema::dropIfExists('students');
    }
};
