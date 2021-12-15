<?php

use RalphJSmit\Stubs\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

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
