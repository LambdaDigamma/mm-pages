<?php

namespace LambdaDigamma\MMPages\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LambdaDigamma\MMPages\MMPagesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
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
