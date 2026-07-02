<?php
// app/Models/Student.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id','student_code','grade','field','birth_date','address','postal_code',
        'father_name','father_phone','mother_name','mother_lastname','mother_phone',
        'prev_school','prev_district','prev_principal','prev_counselor',
        'last_gpa','discipline_score','photo_path','guidance_doc_path',
        'enrollment_status','enrollment_note',
    ];

    public function user() { return $this->belongsTo(User::class); }

    public function getFieldLabelAttribute(): string {
        return match($this->field) {
            'electrical' => 'برق صنعتی',
            'mechanical' => 'تاسیسات مکانیکی',
            'instrumentation' => 'تعمیرکار ابزار دقیق',
            default => $this->field,
        };
    }

    public function getStatusLabelAttribute(): string {
        return match($this->enrollment_status) {
            'pending' => 'در انتظار بررسی',
            'accepted' => 'پذیرفته شده',
            'rejected' => 'رد شده',
            'waiting' => 'لیست انتظار',
            default => '—',
        };
    }
}
