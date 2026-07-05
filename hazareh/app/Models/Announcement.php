<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'author_id','title','body','section','priority','expires_at','is_active',
    ];

    protected $casts = ['is_active' => 'boolean', 'expires_at' => 'date'];

    public function author() { return $this->belongsTo(User::class, 'author_id'); }

    public function getSectionLabelAttribute(): string {
        return match($this->section) {
            'educational' => 'آموزشی',
            'counseling' => 'مشاوره‌ای',
            'nurturing' => 'پرورشی',
            default => $this->section,
        };
    }
}
