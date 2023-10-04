<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
use DB;
use Illuminate\Support\Facades\View;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength('191');
        Paginator::useBootstrap();
        Blade::directive('datetime', function ($value) {
            return "<?php echo ($value)->format('M d, Y').' at '($value)->format('H:i'); ?>";
        });

        
        $menus = DB::select(DB::raw("select * from menu"));
        View::share('menus',$menus);
    }


}
