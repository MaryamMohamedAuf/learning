<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Sentry\State\Scope;

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
        if (app()->bound('sentry')) {
            \Sentry\configureScope(static function (Scope $scope): void {
                $user = auth()->user();

                if ($user !== null) {
                    $scope->setUser([
                        'id' => (string) $user->id,
                        'email' => $user->email,
                        'name' => $user->name,
                    ]);
                }
            });
        }
    }
}
