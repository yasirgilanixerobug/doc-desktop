<?php

namespace App\Providers;

use App\View\Composers\ClinicComposer;
use App\View\Composers\PendingAppointmentComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PendingAppointmentComposer::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers in clinic navbar for clinic data with cache ...
        View::composer('clinic.frontend.*', ClinicComposer::class);

        //Use pending appointment notification list and counter
        View::composer(['clinic.dashboard', 'partial.clinic.nav','partial.clinic.main-sidebar'], PendingAppointmentComposer::class);
    }
}

