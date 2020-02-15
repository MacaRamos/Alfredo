<?php

namespace App\Providers;

use App\Models\Admin\Menu;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::composer("theme.adminlte.iside", function ($view)
        {
            $menus = Menu::getMenu(true);
            $view->with("menusComposer", $menus);
        });
        View::share('theme', 'adminlte');
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
