<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;  // تأكد من استيراد LogOptions

class File extends Model
{
    use HasFactory,LogsActivity;

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
  
    // تحديد الحقول التي سيتم مراقبتها
    protected static $logAttributes = ['name', 'status', 'user_id']; // سمات يمكن أن تُسجل في السجل
    protected static $logName = 'file'; // اسم السجل في سجل الأنشطة
  
    // تحديد العمليات التي يجب مراقبتها (إنشاء، تعديل، حذف، إلخ)
    protected static $logOnlyDirty = true; // تسجيل فقط التغييرات التي حصلت
  
    // تخصيص ما يجب تسجيله عند التعديل (يمكنك إضافة الحقول المخصصة)
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];

    // الطريقة الصحيحة لتحديد خيارات السجل
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'status', 'user_id'])  // الحقول التي ترغب في مراقبتها
            ->useLogName('file')  // اسم السجل
            ->logOnlyDirty();  // تسجيل التغييرات فقط
    }

  
    public function group(){
        return $this->belongsTo(Groups::class);
    }
    
    
}
