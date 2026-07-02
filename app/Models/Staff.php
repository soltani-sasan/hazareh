<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'user_id','full_name','role_title','department','bio','photo','sort_order','is_active',
    ];
    protected $casts = ['is_active' => 'boolean'];
    public $timestamps = false;

    public function user() { return $this->belongsTo(User::class); }

    public function getDepartmentLabelAttribute(): string {
        return match($this->department) {
            'teaching' => 'کادر آموزشی',
            'research' => 'کادر پژوهشی',
            'admin' => 'کادر اداری',
            'pta' => 'انجمن اولیا و مربیان',
            default => $this->department,
        };
    }
}
