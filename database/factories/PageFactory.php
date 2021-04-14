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

    public function notPublished()
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => null,
            ];
        });
    }

    public function archived()
    {
        return $this->state(function (array $attributes) {
            return [
                'archived_at' => now(),
            ];
        });
    }

    public function notArchived()
    {
        return $this->state(function (array $attributes) {
            return [
                'archived_at' => null,
            ];
        });
    }

}
