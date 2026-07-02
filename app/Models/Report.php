<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['author_id','title','body','type','report_date'];
    public $timestamps = false;
    const CREATED_AT = 'created_at';
    protected $casts = ['report_date' => 'date'];

    public function author() { return $this->belongsTo(User::class, 'author_id'); }

    public function getTypeLabelAttribute(): string {
        return match($this->type) {
            'action' => 'اقدام انجام‌شده',
            'visit' => 'بازدید',
            'future' => 'کار آتی',
            default => 'عمومی',
        };
    }
}
