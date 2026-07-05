<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Judge extends Model
{
    protected $fillable = ['user_id','name','title','organization','track','bio','photo'];
    public $timestamps = false;

    public function user() { return $this->belongsTo(User::class); }
}
