<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Client;
use App\Models\Clothes;
use App\Models\Event;
use App\Models\Hair;
use App\Models\Look;
use App\Models\Makeup;
use App\Models\Season;
use App\Models\Style;
use App\Models\User;
use App\Policies\ClientPolicy;
use App\Policies\ClothesPolicy;
use App\Policies\EventPolicy;
use App\Policies\HairPolicy;
use App\Policies\LookPolicy;
use App\Policies\MakeupPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\SeasonPolicy;
use App\Policies\StylePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Client::class => ClientPolicy::class,
        Clothes::class => ClothesPolicy::class,
        Event::class => EventPolicy::class,
        Hair::class => HairPolicy::class,
        Look::class => LookPolicy::class,
        Makeup::class => MakeupPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        Season::class => SeasonPolicy::class,
        Style::class => StylePolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
