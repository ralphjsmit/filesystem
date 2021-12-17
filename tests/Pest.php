<?php

use Illuminate\Support\Str;
use RalphJSmit\Stubs\Stubs;
use RalphJSmit\Stubs\Tests\TestCase;

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

function rmdir_recursive(string $dir): void
{
    foreach (scandir($dir) as $file) {
        if ( '.' === $file || '..' === $file ) {
            continue;
        }

        if ( is_dir("$dir/$file") ) {
            rmdir_recursive("$dir/$file");
        } else {
            unlink("$dir/$file");
        }
    }
    rmdir($dir);
}

expect()->extend('toExist', function () {
    expect(
        file_exists($this->value)
    )->toBeTrue();

    return $this;
});

expect()->extend('toHaveContents', function (mixed $contents) {
    expect(
        file_get_contents($this->value)
    )->toBe(
        $contents
    );

    return $this;
});

expect()->extend('toHaveNamespace', function (string $namespace) {
    expect(
        (string) Str::of(
            file_get_contents($this->value)
        )->after('namespace')->before(';')->trim()
    )->toBe($namespace);

    return $this;
});
