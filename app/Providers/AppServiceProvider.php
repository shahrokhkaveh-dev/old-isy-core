<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Province;
use App\Repositories\FileRepository;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Repositories\Interfaces\SlideRepositoryInterface;
use App\Repositories\Interfaces\SliderRepositoryInterface;
use App\Repositories\SlideRepository;
use App\Repositories\SliderRepository;
use App\Services\Contracts\ReferralServiceInterface;
use App\Services\ModuleLoader;
use App\Services\ReferralService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ModuleLoader::loadModules();

        // Binding Slider Repository
        $this->app->bind(SliderRepositoryInterface::class, SliderRepository::class);

        // Binding Slide Repository
        $this->app->bind(SlideRepositoryInterface::class, SlideRepository::class);

        // Binding File Repository
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);

        $this->app->bind(ReferralServiceInterface::class, ReferralService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        // URL::forceScheme('https');
        view()->composer('user.layout.nav', function ($view) {
            $provinces = Province::all();
            $categories = DB::table('categories')->where('parent_id' , null)->get();
            $view->with('provinces', $provinces)->with('categories' , $categories);
        });
        view()->composer('web.layout.header',function ($view){
            $categories = $categories = getCategoriesWithSubcategories();
            $view->with([
                'categories'=>$categories
            ]);
        });
    }
}

