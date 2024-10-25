<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;
    protected $guarded = [];

public function files(){
    return $this->belongsToMany(File::class,'group_files','group_id')->withPivot('id');
}
}