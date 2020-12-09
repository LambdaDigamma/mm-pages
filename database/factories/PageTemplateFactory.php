<?php

namespace LambdaDigamma\MMPages\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use LambdaDigamma\MMPages\Models\Page;
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
