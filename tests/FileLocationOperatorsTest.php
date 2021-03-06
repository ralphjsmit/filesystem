<?php

use RalphJSmit\Filesystem\Stub;

it('can copy a file to a new location', function () {
    $file = Stub::file(__DIR__ . '/__fixtures__/demo-application/CopyFile.php')
        ->copy(__DIR__ . '/tmp/demo-application');

    expect(
        file_get_contents(__DIR__ . '/__fixtures__/demo-application/CopyFile.php')
    )->toBe(
        file_get_contents(__DIR__ . '/tmp/demo-application/CopyFile.php')
    );

    expect($file->getFilepath())->toBe(__DIR__ . '/tmp/demo-application/CopyFile.php');
    expect($file->getDirectory())->toBe(__DIR__ . '/tmp/demo-application');
});

it('can move a file to a new location', function () {
    $file = Stub::file(__DIR__ . '/__fixtures__/demo-application/MoveFile.php')
        ->copy(__DIR__ . '/tmp/demo-application/a');

    $contents = file_get_contents(__DIR__ . '/__fixtures__/demo-application/MoveFile.php');
    expect($contents)->toBe(file_get_contents(__DIR__ . '/tmp/demo-application/a/MoveFile.php'));
    expect($file)
        ->filepath->toBe(__DIR__ . '/tmp/demo-application/a/MoveFile.php')
        ->getBasepath()->toBe('');

    $file = Stub::file(__DIR__ . '/tmp/demo-application/a/MoveFile.php')
        ->move(__DIR__ . '/tmp/demo-application/b');

    expect(__DIR__ . '/__fixtures__/demo-application/a/MoveFile.php')->not->toExist();
    expect(__DIR__ . '/tmp/demo-application/b/MoveFile.php')->toHaveContents($contents);
    expect($file)
        ->filepath->toBe(__DIR__ . '/tmp/demo-application/b/MoveFile.php')
        ->getBasepath()->toBe('');
});

it('can copy a file to a new location with relative __DIR__', function () {
    $basePath = $this->stubs->getBasepath();
    $file = $this->stubs->getFile('/__fixtures__/demo-application/CopyFile.php')
        ->copy('/tmp/demo-application');

    expect(
        file_get_contents(__DIR__ . '/__fixtures__/demo-application/CopyFile.php')
    )->toBe(
        file_get_contents(__DIR__ . '/tmp/demo-application/CopyFile.php')
    );

    expect($file)
        ->filepath->toBe('/tmp/demo-application/CopyFile.php')
        ->getBasepath()->toBe($basePath);
});

it('can move a file to a new location with relative __DIR__', function () {
    $basePath = $this->stubs->getBasepath();
    $file = $this->stubs->getFile('/__fixtures__/demo-application/MoveFile.php')
        ->copy('/tmp/demo-application/a');

    $contents = file_get_contents(__DIR__ . '/__fixtures__/demo-application/MoveFile.php');
    expect($contents)->toBe(file_get_contents(__DIR__ . '/tmp/demo-application/a/MoveFile.php'));
    expect($file)
        ->filepath->toBe('/tmp/demo-application/a/MoveFile.php')
        ->getBasepath()->toBe($basePath);

    $file = $this->stubs->getFile('/tmp/demo-application/a/MoveFile.php')
        ->move('/tmp/demo-application/b');

    expect(__DIR__ . '/__fixtures__/demo-application/a/MoveFile.php')
        ->not->toExist();
    expect(__DIR__ . '/tmp/demo-application/b/MoveFile.php')
        ->toHaveContents($contents);
    expect($file)
        ->filepath->toBe('/tmp/demo-application/b/MoveFile.php')
        ->getBasepath()->toBe($basePath);
});
