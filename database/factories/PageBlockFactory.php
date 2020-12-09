<?php

namespace LambdaDigamma\MMPages\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LambdaDigamma\MMPages\Models\PageBlock;

class PageBlockFactory extends Factory
{
    protected $model = PageBlock::class;

    public function definition()
    {
        return [
            'type' => $this->faker->sentence(3),
        ];
    }

}
