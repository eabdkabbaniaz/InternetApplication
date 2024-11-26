<?php

namespace App\Providers;

use App\Repositories\BookingRepository;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\FileRepository;
use App\Repositories\FileRepositoryInterface;
use App\Repositories\GroupRepository;
use App\Repositories\GroupRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use GoAop\Aop\AspectKernel;
use App\Aop\LoggingAspect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function ($query) {
            Log::info('Query Executed', [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time,
                'api_user' => request()->user()?->id ?? 'guest', // ربط الاستعلام بالمستخدم
            ]);
        });
        // تأكد من أن الـ Aspect مضاف إلى الـ Kernel
    }
}
