<?php

namespace RalphJSmit\Filesystem\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use RalphJSmit\Filesystem\StubsServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            StubsServiceProvider::class,
        ];
    }
}
