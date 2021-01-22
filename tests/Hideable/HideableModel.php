<?php

namespace LambdaDigamma\MMPages\Tests\Hideable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LambdaDigamma\MMPages\Traits\Hideable;

class HideableModel extends Model
{
    use Hideable;
    use HasFactory;

    protected static function newFactory()
    {
        return HideableModelFactory::new();
    }
}
