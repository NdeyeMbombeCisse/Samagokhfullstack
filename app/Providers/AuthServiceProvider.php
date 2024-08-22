<?php
// app/Providers/AuthServiceProvider.php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;
use App\Policies\PermissionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Permission::class => PermissionPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}

