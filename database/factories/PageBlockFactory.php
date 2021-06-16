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

    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => now(),
            ];
        });
    }

    public function expired()
    {
        return $this->state(function (array $attributes) {
            return [
                'expired_at' => now(),
            ];
        });
    }

}
