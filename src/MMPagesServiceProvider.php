<?php

namespace LambdaDigamma\MMPages;

use Illuminate\Support\ServiceProvider;
use LambdaDigamma\MMPages\Commands\MMPagesCommand;

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

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mm-pages');
    }

    public function register()
    {
        $this->app->register('LaravelArchivable\LaravelArchivableServiceProvider');

        $this->mergeConfigFrom(__DIR__ . '/../config/mm-pages.php', 'mm-pages');
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
}
