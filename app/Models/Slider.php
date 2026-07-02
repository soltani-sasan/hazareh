<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = ['title','subtitle','image','link','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];
    public $timestamps = false;
}
