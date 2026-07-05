<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['slug','title','body','updated_by'];
    public $timestamps = false;
    protected $touches = [];
    const UPDATED_AT = 'updated_at';

    public function editor() { return $this->belongsTo(User::class, 'updated_by'); }
}
