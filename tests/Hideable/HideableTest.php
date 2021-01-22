<?php

namespace LambdaDigamma\MMPages\Tests;

use LambdaDigamma\MMPages\Tests\Hideable\HideableModel;
use LambdaDigamma\MMPages\Tests\Hideable\RegularModel;

class HideableTest extends TestCase
{
    /** @test */
    public function a_model_can_be_hidden()
    {
        $model = HideableModel::factory()->create();

        $this->assertNull($model->fresh()->hidden_at);

        $model->hide();

        $this->assertNotNull($model->fresh()->hidden_at);
    }

    /** @test */
    public function a_model_can_be_showed()
    {
        $model = HideableModel::factory()->hidden()->create();

        $this->assertNotNull($model->fresh()->hidden_at);

        $model->show();

        $this->assertNull($model->fresh()->hidden_at);
    }

    /** @test */
    public function a_model_cannot_be_queried_normally_when_hidden()
    {
        HideableModel::factory()->hidden()->create();

        HideableModel::factory()->create();

        $this->assertDatabaseCount('hideable_models', 2);

        $this->assertCount(1, HideableModel::all());
    }

    /** @test */
    public function all_models_can_be_found_with_the_withArchived_scope()
    {
        HideableModel::factory()->hidden()->create();
        HideableModel::factory()->create();

        $this->assertCount(2, HideableModel::withHidden()->get());
    }

    /** @test */
    public function only_hidden_models_can_be_found_with_the_onlyHidden_scope()
    {
        HideableModel::factory()->hidden()->create();
        HideableModel::factory()->create();

        $this->assertCount(1, HideableModel::onlyHidden()->get());
    }

    /** @test */
    public function models_without_the_hideable_trait_are_not_scoped()
    {
        RegularModel::factory()->create();

        $this->assertCount(1, RegularModel::all());
    }
}
