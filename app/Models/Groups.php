<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;
    protected $guarded = [];

public function files(){
    return $this->hasMany(File::class,'group_id');
}
public function users(){
    return $this->belongsToMany(User::class,'group_users','group_id');
}

}