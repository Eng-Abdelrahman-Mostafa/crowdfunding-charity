<?php

namespace App\Providers;

use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar','en']); // also accepts a closure
        });
        Gate::policy('User', \App\Policies\UserPolicy::class);
        Gate::policy('Association', \App\Policies\AssociationPolicy::class);
        Gate::policy('Campaign', \App\Policies\CampaignPolicy::class);
        Gate::policy('DonationCategory', \App\Policies\DonationCategoryPolicy::class);
        Gate::policy('Donation', \App\Policies\DonationPolicy::class);
        Gate::policy('Withdrawal', \App\Policies\WithdrawalPolicy::class);
        Gate::policy('Expenditure', \App\Policies\ExpenditurePolicy::class);
    }
}
