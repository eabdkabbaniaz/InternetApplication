<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupFile extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function files(){
        return $this->hasMany(File::class,'group_id');
    }
}
