<?php

namespace App\Providers;

use App\Models\{
    Certification,
    Contractor,
    SpecialtyWorker,
    Worker,
    Work
};
use App\Observers\{
    CertificationObserver,
    ContractorObserver,
    SpecialtyWorkerObserver,
    WorkerObserver,
    WorkObserver
};
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Certification::class => [CertificationObserver::class],
        SpecialtyWorker::class => [SpecialtyWorkerObserver::class],
        Contractor::class => [ContractorObserver::class],
        Worker::class => [WorkerObserver::class],
        Work::class => [WorkObserver::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
