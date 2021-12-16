<?php

use RalphJSmit\Stubs\Exceptions\NamespaceNotFoundException;
use RalphJSmit\Stubs\Stubs;

beforeEach(function () {
    if ( file_exists(__DIR__ . '/tmp') ) {
        rmdir_recursive(__DIR__ . '/tmp');
    }

    mkdir(__DIR__ . '/tmp', 0777, true);
    mkdir(__DIR__ . '/tmp/demo-application', 0777, true);

    Stubs::file(__DIR__ . '/__fixtures__/demo-application/App/Models/MyModel.php')
        ->copy(__DIR__ . '/tmp/demo-application/App/Models/');
});

it('it can update the namespace of a file', function () {
    $contents = <<<PHP
    <?php

    namespace App\Models;

    class User extends Model {}
    PHP;

    Stubs::file(__DIR__ . '/tmp/demo-application/App/Models/User.php')
        ->putFile($contents);

    Stubs::file(__DIR__ . '/tmp/demo-application/App/Models/User.php')
        ->putInFolder(__DIR__ . '/tmp/demo-application/Domain/Auth/Models/')
        ->replaceNamespace('Domain\Auth\Models');

    expect(__DIR__ . '/tmp/demo-application/Domain/Auth/Models/User.php')
        ->toHaveContents(
            <<<PHP
            <?php
            
            namespace Domain\Auth\Models;
            
            class User extends Model {}
            PHP
        )
        ->toHaveNamespace('Domain\Auth\Models');
});

test('it can move a file based on the namespace', function () {
    $stubs = Stubs::new()->namespaces([
        'Support' => __DIR__ . '/tmp/demo-application/Support',
        'Domain' => __DIR__ . '/tmp/demo-application/Domain',
        'App' => __DIR__ . '/tmp/demo-application/App',
    ]);

    $stubs->getFile(__DIR__ . '/tmp/demo-application/App/Models/MyModel.php')
        ->namespace('Support\General\Models');

    expect(__DIR__ . '/tmp/demo-application/Support/General/Models/MyModel.php')
        ->toExist()
        ->toHaveNamespace('Support\General\Models');

    expect(__DIR__ . '/tmp/demo-application/App/Models/MyModel.php')
        ->not->toExist();
});

test('it throws an exception when the namespace is not found', function () {
    $this->expectException(NamespaceNotFoundException::class);

    $stubs = Stubs::new();

    $stubs->getFile(__DIR__ . '/tmp/demo-application/App/Models/User.php')
        ->namespace('Support\Models');
});