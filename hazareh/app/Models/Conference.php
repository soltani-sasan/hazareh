<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $table = 'conference';
    protected $fillable = [
        'title','description','start_date','end_date','submission_deadline','venue','is_active',
    ];
    protected $casts = [
        'start_date' => 'date', 'end_date' => 'date',
        'submission_deadline' => 'date', 'is_active' => 'boolean',
    ];

    public function registrations() { return $this->hasMany(ConferenceRegistration::class); }
}
