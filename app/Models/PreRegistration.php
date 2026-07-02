<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PreRegistration extends Model
{
    protected $fillable = [
        'national_id','first_name','last_name','birth_date','home_phone','mobile',
        'introducer_name','father_name','father_mobile','mother_name','mother_lastname','mother_mobile',
        'prev_school','prev_district','prev_principal','prev_counselor','last_gpa','discipline_score',
        'requested_field','how_known','address','postal_code','guidance_doc','status','admin_note',
    ];

    public function getFieldLabelAttribute(): string {
        return match($this->requested_field) {
            'electrical' => 'برق صنعتی',
            'mechanical' => 'تاسیسات مکانیکی',
            'instrumentation' => 'تعمیرکار ابزار دقیق',
            default => $this->requested_field,
        };
    }

    public function getStatusLabelAttribute(): string {
        return match($this->status) {
            'pending' => 'در انتظار بررسی',
            'reviewed' => 'در حال بررسی',
            'accepted' => 'پذیرفته شده',
            'rejected' => 'رد شده',
            default => '—',
        };
    }

    public function getStatusBadgeAttribute(): string {
        return match($this->status) {
            'pending' => 'badge-warning',
            'reviewed' => 'badge-primary',
            'accepted' => 'badge-success',
            'rejected' => 'badge-danger',
            default => 'badge-primary',
        };
    }
}
