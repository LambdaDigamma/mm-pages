<?php

namespace LambdaDigamma\MMPages\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use LambdaDigamma\MMPages\Models\Page;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition()
    {
        return [
            'title' => ['en' => $this->faker->sentence(3)],
            'summary' => ['en' => $this->faker->sentence(10, true)]
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

}
