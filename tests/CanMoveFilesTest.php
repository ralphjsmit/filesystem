<?php

use RalphJSmit\Stubs\Stubs;

beforeEach(function () {
    rmdir_recursive(__DIR__ . '/tmp');
});

it('it can copy a file to a new location', function () {
    mkdir(__DIR__ . '/tmp/demo-application', 0777, true);

    expect(is_dir(__DIR__ . '/tmp/demo-application'))->toBeTrue();

    Stubs::file(__DIR__ . '/__fixtures__/demo-application/MoveFile.php')
        ->copy(__DIR__ . '/tmp/demo-application');

    expect(
        file_get_contents(__DIR__ . '/__fixtures__/demo-application/MoveFile.php')
    )->toBe(
        file_get_contents(__DIR__ . '/tmp/demo-application/MoveFile.php')
    );
});

it('it can move a file to a new location', function () {
    mkdir(__DIR__ . '/tmp/demo-application', 0777, true);

    expect(is_dir(__DIR__ . '/tmp/demo-application'))->toBeTrue();
    //
});
