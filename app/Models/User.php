<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'confirmation_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function groups(){
        return $this->belongsToMany(Groups::class,'group_users','user_id','group_id')->withPivot('id','is_admin');
    }


    public function isAdmin($groupId)
    {
        return $this->groups()->where('group_id', $groupId)->where('is_admin', true)->exists();
    }

    public function isRegularUser($groupId)
    {
        return $this->groups()->where('group_id', $groupId)->where('is_admin', false)->exists();
    }
    public function fileReservation()
    {
        return $this->belongsToMany(File::class, 'bookings')
                    ->whereNull('bookings.deleted_at')  // إضافة شرط لعدم إرجاع الحجوزات المحذوفة
                    ->withPivot('id');
    }
    
   
}
