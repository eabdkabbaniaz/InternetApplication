<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;
    protected $guarded = [];

public function files(){
    return $this->hasMany(File::class,'group_id')->where('Active',1);
}
public function users(){
    return $this->belongsToMany(User::class,'group_users','group_id')->where('is_admin',0)->where('isAccept',1);
}
public function waitusers(){
    return $this->belongsToMany(User::class,'group_users','group_id')->where('is_admin',0)->where('isAccept',0);
}

}