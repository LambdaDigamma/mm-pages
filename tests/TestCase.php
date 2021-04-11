<?php

namespace LambdaDigamma\MMPages\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LambdaDigamma\MMPages\MMPagesServiceProvider;
use Mavinoo\Batch\BatchServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\JsonApiPaginate\JsonApiPaginateServiceProvider;
use Spatie\LaravelRay\RayServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setupDatabase();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'LambdaDigamma\\MMPages\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            MMPagesServiceProvider::class,
            BatchServiceProvider::class,
            JsonApiPaginateServiceProvider::class,
            RayServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    private function setupDatabase()
    {
        $this->loadLaravelMigrations();
        include_once __DIR__.'/../database/migrations/create_mm_pages_table.php.stub';
        (new \CreateMMPagesTable())->up();

        Schema::create('hideable_models', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->timestamp('hidden_at', 0)->nullable();
        });

        Schema::create('regular_models', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }
}
