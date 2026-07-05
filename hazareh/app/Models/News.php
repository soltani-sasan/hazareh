<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'author_id','title','slug','body','image','category','grade','type',
        'is_published','published_at',
    ];

    protected $casts = ['is_published' => 'boolean', 'published_at' => 'datetime'];

    public function author() { return $this->belongsTo(User::class, 'author_id'); }

    public function scopePublished($q) { return $q->where('is_published', 1); }

    public function getCategoryLabelAttribute(): string {
        return match($this->category) {
            'electrical' => 'برق صنعتی',
            'mechanical' => 'تاسیسات مکانیکی',
            'instrumentation' => 'ابزار دقیق',
            'extra' => 'فوق‌برنامه',
            default => 'عمومی',
        };
    }

    protected static function booted()
    {
        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = \Illuminate\Support\Str::slug($news->title) . '-' . uniqid();
            }
        });
    }
}
