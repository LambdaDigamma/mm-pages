<?php

namespace LambdaDigamma\MMPages;

use Illuminate\Database\Schema\Blueprint;
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

        $this->configureMacros();
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mm-pages');
    }

    public function register()
    {
        $this->app->register('LaravelArchivable\LaravelArchivableServiceProvider');

        $this->mergeConfigFrom(__DIR__ . '/../config/mm-pages.php', 'mm-pages');
    }

    /**
     * Configure the macros to be used.
     *
     * @return void
     */
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
}
