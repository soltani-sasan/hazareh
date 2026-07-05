<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CounselingRequest extends Model
{
    protected $fillable = [
        'sender_type','full_name','national_id','parent_name','home_phone','mobile','email',
        'reply_via','subject','is_private','message','status','responder_id',
        'response_text','responded_at',
    ];

    protected $casts = ['is_private' => 'boolean', 'responded_at' => 'datetime'];

    public function responder() { return $this->belongsTo(User::class, 'responder_id'); }
}
