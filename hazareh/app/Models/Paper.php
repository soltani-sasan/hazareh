<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $fillable = [
        'author_id','title','abstract','keywords','track','file_path','status',
    ];

    public function author() { return $this->belongsTo(User::class, 'author_id'); }
    public function reviews() { return $this->hasMany(PaperReview::class); }

    public function getTrackLabelAttribute(): string {
        return match($this->track) {
            'instrumentation' => 'تعمیر و نگهداری ابزار دقیق',
            'mechanical' => 'تاسیسات مکانیکی',
            'electrical' => 'برق صنعتی',
            'innovation' => 'نوآوری و ایده‌های جدید',
            default => $this->track,
        };
    }

    public function getStatusLabelAttribute(): string {
        return match($this->status) {
            'submitted' => 'ارسال شده',
            'under_review' => 'در حال داوری',
            'accepted' => 'پذیرفته شده',
            'rejected' => 'رد شده',
            'revision' => 'نیازمند اصلاح',
            default => $this->status,
        };
    }

    public function getAverageScoreAttribute() {
        return round($this->reviews()->avg('total_score'), 1);
    }
}
