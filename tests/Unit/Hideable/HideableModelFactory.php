<?php

namespace LambdaDigamma\MMPages\Tests\Unit\Hideable;

use Illuminate\Database\Eloquent\Factories\Factory;

class HideableModelFactory extends Factory
{
    protected $model = HideableModel::class;

    public function hidden()
    {
        return $this->state(function (array $attributes) {
            return [
                'hidden_at' => now(),
            ];
        });
    }

    public function definition()
    {
        return [];
    }
}
