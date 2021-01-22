<?php

namespace LambdaDigamma\MMPages\Tests\Hideable;

use Illuminate\Database\Eloquent\Factories\Factory;

class RegularModelFactory extends Factory
{
    protected $model = RegularModel::class;

    public function definition()
    {
        return [];
    }
}
