<?php

use RalphJSmit\Stubs\Stubs;

beforeEach(function () {
    if ( file_exists(__DIR__ . '/tmp') ) {
        rmdir_recursive(__DIR__ . '/tmp');
    }

    mkdir(__DIR__ . '/tmp', 0777, true);
    mkdir(__DIR__ . '/tmp/demo-application', 0777, true);
});

it('it can update the namespace of a file', function () {
    $contents = <<<PHP
    <?php

    namespace App\Models;

    class User extends Model
    {
    }
    PHP;

    Stubs::file(__DIR__ . '/tmp/demo-application/App/Models/User.php')
        ->putFile($contents);

    Stubs::file(__DIR__ . '/tmp/demo-application/App/Models/User.php')
        ->putInFolder(__DIR__ . '/tmp/demo-application/Domain/Auth/Models/')
        ->replaceNamespace('Domain\Auth\Models');

    dump(file_get_contents(__DIR__ . '/tmp/demo-application/Domain/Auth/Models/User.php'));
    expect(__DIR__ . '/tmp/demo-application/Domain/Auth/Models/User.php')
        ->toHaveContents(
            <<<PHP
            <?php
            
            namespace Domain\Auth\Models;
            
            class User extends Model
            {
            }
            PHP

        );
});