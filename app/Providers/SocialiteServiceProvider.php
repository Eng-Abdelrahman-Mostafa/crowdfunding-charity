<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use SocialiteProviders\Facebook\FacebookExtendSocialite;
use SocialiteProviders\Google\GoogleExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;

class SocialiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->make(Factory::class)->extend('facebook', function ($app) {
            $config = $app['config']['services.facebook'];
            return $this->buildProvider(
                'SocialiteProviders\\Facebook\\Provider',
                $config
            );
        });

        $this->app->make(Factory::class)->extend('google', function ($app) {
            $config = $app['config']['services.google'];
            return $this->buildProvider(
                'SocialiteProviders\\Google\\Provider',
                $config
            );
        });
        
        $this->app['events']->listen(SocialiteWasCalled::class, [FacebookExtendSocialite::class, 'handle']);
        $this->app['events']->listen(SocialiteWasCalled::class, [GoogleExtendSocialite::class, 'handle']);
    }
    
    /**
     * Build a provider instance.
     *
     * @param string $provider
     * @param array $config
     * @return mixed
     */
    protected function buildProvider($provider, $config)
    {
        return new $provider(
            $this->app['request'],
            $config['client_id'] ?? null,
            $config['client_secret'] ?? null,
            $config['redirect'] ?? null,
            $config['guzzle'] ?? []
        );
    }
}
