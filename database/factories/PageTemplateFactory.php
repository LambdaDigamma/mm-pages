<?php

namespace LambdaDigamma\MMPages\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LambdaDigamma\MMPages\Models\PageTemplate;

class PageTemplateFactory extends Factory
{
    protected $model = PageTemplate::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
