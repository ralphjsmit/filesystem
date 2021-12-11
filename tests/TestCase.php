<?php

namespace RalphJSmit\Stubs\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use RalphJSmit\Stubs\StubsServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            StubsServiceProvider::class,
        ];
    }
}
