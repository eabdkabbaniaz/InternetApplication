<?php

use Okapi\Aop\Attributes\Aspect;
use Okapi\Aop\Attributes\After;
use Okapi\Aop\Attributes\Before;
use Okapi\Aop\Invocation\AfterMethodInvocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\File\FileController;

// تعريف الناحية
#[Aspect]
class OperationLogAspect
{
    #[After(
        class: FileController::class,
        method: '(store|update|destroy|deActiveStatus)',
        onlyPublicMethods: true,
    )]
    public function logOperation(AfterMethodInvocation $invocation): void
    {
        try{

        // الكائن الذي تم استدعاء الطريقة منه
        $subject = $invocation->getSubject();

        // اسم الطريقة
        $methodName = $invocation->getMethodName();

        // التفاصيل المدخلة إلى الطريقة
        $arguments = json_encode($invocation->getArguments());

        // اسم المستخدم (إذا كان مسجل الدخول)
        $user = Auth::user() ? Auth::user()->name : 'Guest';

        // تحديد نوع العملية بناءً على اسم الطريقة
        $operation = '';
        if (strpos($methodName, 'store') === 0) {
            $operation = 'Add';
        } elseif (strpos($methodName, 'update') === 0) {
            $operation = 'Edit';
        } elseif (strpos($methodName, 'destroy') === 0) {
            $operation = 'Delete';
        } elseif (strpos($methodName, 'deActiveStatus') === 0) {
            $operation = 'Reserve';
        }

        // إدخال السجل في قاعدة البيانات
        DB::table('system_logs')->insert([
            'operation' => $operation,
            'user' => $user,
            'details' => $arguments,
            'timestamp' => now(),
        ]);
    }


    catch (\Exception $e) {
dd($e->getMessage());
    }
        // \Log::error('Error in OperationLogAspect: ' . $e->getMessage());    }
}
}
