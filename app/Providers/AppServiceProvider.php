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
        // โหลด policy mappings ที่กำหนดไว้ด้านบน
        $this->registerPolicies();

        // ถ้าต้องการ Gate อื่น ๆ สามารถเพิ่มได้ที่นี่ เช่น
        // Gate::define('is-admin', fn($user) => $user->is_admin);
    }
}
