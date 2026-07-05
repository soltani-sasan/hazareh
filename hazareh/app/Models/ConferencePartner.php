<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ConferencePartner extends Model
{
    protected $fillable = ['name','logo','type','sort_order'];
    public $timestamps = false;
}
