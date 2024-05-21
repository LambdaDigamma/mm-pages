<?php

namespace LambdaDigamma\MMPages\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LambdaDigamma\MMPages\Models\MenuItem;

class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;

    public function definition()
    {
        return [
            'title' => ['en' => $this->faker->sentence(3)],
        ];
    }
}
