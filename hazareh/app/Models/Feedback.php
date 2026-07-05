<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $fillable = ['full_name','email','type','message','is_read'];
    public $timestamps = false;
    const CREATED_AT = 'created_at';
    protected $casts = ['is_read' => 'boolean'];
}
