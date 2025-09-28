<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\SocialMediaLink;
use App\Policies\SocialMediaLinkPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        SocialMediaLink::class => SocialMediaLinkPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Load policy mappings defined above
        $this->registerPolicies();

        // Add custom Gates here if needed, for example:
        // Gate::define('is-admin', fn($user) => $user->is_admin);
    }
}