<?php

namespace App\Aspects;

use GoAop\Aop\AfterReturningAdvice;
use GoAop\Aop\JoinPoint;

class LoggingAspect implements AfterReturningAdvice
{
    public function invoke(JoinPoint $joinPoint)
    {
        // سجل العملية بعد الانتهاء منها
        \Log::info("Method " . $joinPoint->getMethod()->getName() . " executed.");
    }
}
