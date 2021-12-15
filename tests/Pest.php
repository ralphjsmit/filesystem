<?php

use RalphJSmit\Stubs\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function rmdir_recursive(string $dir): void
{
    foreach (scandir($dir) as $file) {
        if ('.' === $file || '..' === $file) {
            continue;
        }
        if (is_dir("$dir/$file")) {
            rmdir_recursive("$dir/$file");
        } else {
            unlink("$dir/$file");
        }
    }
    rmdir($dir);
}
