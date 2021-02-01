<?php

namespace LambdaDigamma\MMPages;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use LambdaDigamma\MMPages\Commands\MMPagesCommand;
use LambdaDigamma\MMPages\Models\Page;
use LambdaDigamma\MMPages\Models\PageBlock;

class MMPagesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/mm-pages.php' => config_path('mm-pages.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/mm-pages'),
            ], 'views');

            $migrationFileName = 'create_mm_pages_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                MMPagesCommand::class,
            ]);
        }

        $this->configureMacros();
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mm-pages');
        $this->registerRoutes();
    }

    public function register()
    {
        $this->app->register('LaravelArchivable\LaravelArchivableServiceProvider');

        $this->mergeConfigFrom(__DIR__ . '/../config/mm-pages.php', 'mm-pages');
    }

    protected function configureMacros()
    {
        Blueprint::macro('hiddenAt', function ($column = 'hidden_at', $precision = 0) {
            return $this->timestamp($column, $precision)->nullable();
        });
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Register all admin and api routes.
     *
     */
    protected function registerRoutes()
    {
        Route::bind('anypage', function ($id) {
            return Page::query()
                ->withTrashed()
                ->withArchived()
                ->findOrFail($id);
        });

        Route::bind('anyblock', function ($id) {
            return PageBlock::query()
                ->withHidden()
                ->withTrashed()
                ->findOrFail($id);
        });

        Route::group($this->apiRouteConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });

        Route::group($this->adminRouteConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');
        });
    }

    protected function apiRouteConfiguration()
    {
        return [
            'prefix' => config('mm-pages.api_prefix', 'api'),
            'middleware' => config('mm-pages.api_middleware', ['api']),
            'as' => 'api.',
        ];
    }

    protected function adminRouteConfiguration()
    {
        return [
            'prefix' => config('mm-pages.admin_prefix', 'admin'),
            'middleware' => config('mm-pages.admin_middleware', ['web', 'auth']),
            'as' => 'admin.',
        ];
    }
}
