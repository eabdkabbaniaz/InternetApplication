<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Version(){
        return $this->hasMany(Version::class,'file_id');
    }
    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function booking(){
        return $this->hasmany(Booking::class,'file_id');
    }
}
