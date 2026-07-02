<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'national_id', 'password', 'role', 'avatar', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['is_active' => 'boolean'];

    // ── Role Helpers ──────────────────────────────────────
    public function isAdmin(): bool        { return $this->role === 'admin'; }
    public function isTeacher(): bool      { return in_array($this->role, ['teacher', 'admin']); }
    public function isCounselor(): bool    { return in_array($this->role, ['counselor', 'admin']); }
    public function isJudge(): bool        { return in_array($this->role, ['judge', 'conference_admin', 'admin']); }
    public function isConferenceAdmin(): bool { return in_array($this->role, ['conference_admin', 'admin']); }
    public function isStudent(): bool      { return $this->role === 'student'; }

    public function getRoleLabelAttribute(): string {
        return match($this->role) {
            'admin' => 'مدیر سیستم',
            'student' => 'هنرجو',
            'teacher' => 'دبیر / هنرآموز',
            'counselor' => 'مشاور',
            'judge' => 'داور',
            'conference_admin' => 'مدیر همایش',
            default => 'بازدیدکننده',
        };
    }

    // ── Relations ─────────────────────────────────────────
    public function student()          { return $this->hasOne(Student::class); }
    public function papers()           { return $this->hasMany(Paper::class, 'author_id'); }
    public function counselingRequests() { return $this->hasMany(CounselingRequest::class, 'responder_id'); }
    public function judge()            { return $this->hasOne(Judge::class); }
}
