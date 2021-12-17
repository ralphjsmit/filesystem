<?php

use RalphJSmit\Stubs\Stubs;
use RalphJSmit\Stubs\Tests\TestCase;

use function RalphJSmit\PestPluginFilesystem\rmdir_recursive;

uses(TestCase::class)
    ->beforeEach(function () {
        if ( file_exists(__DIR__ . '/tmp') ) {
            rmdir_recursive(__DIR__ . '/tmp');
        }

        mkdir(__DIR__ . '/tmp', 0777, true);
        mkdir(__DIR__ . '/tmp/demo-application', 0777, true);

        Stubs::file(__DIR__ . '/__fixtures__/demo-application/App/Models/MyModel.php')
            ->copy(__DIR__ . '/tmp/demo-application/App/Models/');

        $this->stubs = Stubs::dir(__DIR__);
    })->in(__DIR__);