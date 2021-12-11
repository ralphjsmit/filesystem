<?php

namespace RalphJSmit\Stubs\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RalphJSmit\Stubs\Stubs
 */
class Stubs extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'stubs';
    }
}
