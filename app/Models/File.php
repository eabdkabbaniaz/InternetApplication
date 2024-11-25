<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Version(){
        return $this->hasMany(Version::class);
    }
    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
}
