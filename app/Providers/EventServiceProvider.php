<?php

namespace App\Providers;

use App\Events\WithdrawalRequested;
use App\Listeners\SendWithdrawalRequestNotification;
use App\Models\Association;
use App\Models\Campaign;
use App\Models\DonationCategory;
use App\Observers\AssociationObserver;
use App\Observers\CampaignObserver;
use App\Observers\DonationCategoryObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        WithdrawalRequested::class => [
            SendWithdrawalRequestNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // Register model observers
        DonationCategory::observe(DonationCategoryObserver::class);
        Campaign::observe(CampaignObserver::class);
        Association::observe(AssociationObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
