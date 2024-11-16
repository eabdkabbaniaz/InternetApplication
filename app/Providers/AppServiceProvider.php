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

use App\Aspects\LoggingAspect;
use GoAop\Aop\Pointcut\Pointcut;

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
        $kernel = App\Providers\AspectKernel::getInstance();
        $kernel->init([ 
            'debug' => true, 
            'cacheDir' => storage_path('framework/aop'), 
            'includePaths' => [app_path()] 
        ]);

        // ربط الـ Aspect بـ Pointcut مناسب
        $kernel->addAspect(new LoggingAspect());
    }
}
