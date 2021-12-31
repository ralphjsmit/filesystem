<?php

use RalphJSmit\Stubs\Exceptions\NamespaceNotFoundException;
use RalphJSmit\Stubs\Stubs;

it('can update the namespace of a file', function () {
    $contents = <<<PHP
        <?php

        namespace App\Models;

        class User extends Model {
            public string \$test = 'namespace App\Models';
        }
        PHP;

    Stubs::file(__DIR__ . '/tmp/demo-application/App/Models/User.php')
        ->putFile($contents);

    $file = Stubs::file(__DIR__ . '/tmp/demo-application/App/Models/User.php')
        ->putInFolder(__DIR__ . '/tmp/demo-application/Domain/Auth/Models/');

    $updatedFile = $file->replaceNamespace('Domain\Auth\Models');
    expect($file)->toBe($updatedFile);

    expect(__DIR__ . '/tmp/demo-application/Domain/Auth/Models/User.php')
        ->toHaveContents(
            <<<PHP
                <?php

                namespace Domain\Auth\Models;

                class User extends Model {
                    public string \$test = 'namespace App\Models';
                }
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
