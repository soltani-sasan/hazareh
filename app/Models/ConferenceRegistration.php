<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ConferenceRegistration extends Model
{
    protected $fillable = [
        'user_id','full_name','national_id','organization','email','phone',
        'participant_type','status',
    ];

    public function user() { return $this->belongsTo(User::class); }

    public function getTypeLabelAttribute(): string {
        return match($this->participant_type) {
            'student' => 'هنرجو', 'teacher' => 'دبیر/هنرآموز',
            'industry' => 'کارکنان صنعت', 'public' => 'عموم مردم', default => 'سایر',
        };
    }
}
