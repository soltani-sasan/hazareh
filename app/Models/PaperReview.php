<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PaperReview extends Model
{
    protected $fillable = [
        'paper_id','judge_id','originality','quality','relevance','presentation',
        'total_score','comments','decision',
    ];
    public $timestamps = false;
    const CREATED_AT = null;
    protected $dates = ['reviewed_at'];

    public function paper() { return $this->belongsTo(Paper::class); }
    public function judge() { return $this->belongsTo(User::class, 'judge_id'); }

    protected static function booted()
    {
        static::saving(function ($review) {
            $review->total_score = round((
                ($review->originality ?? 0) + ($review->quality ?? 0) +
                ($review->relevance ?? 0) + ($review->presentation ?? 0)
            ) / 4, 1);
        });
    }
}
