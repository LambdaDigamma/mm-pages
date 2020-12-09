<?php

namespace LambdaDigamma\MMPages;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LambdaDigamma\MMPages\MMPages
 */
class MMPagesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mm-pages';
    }
}
