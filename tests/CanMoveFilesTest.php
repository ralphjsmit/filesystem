<?php

beforeEach(function () {
    rmdir(__DIR__ . '/tmp');
});

it('it can move a file to a new location', function () {
    mkdir(__DIR__ . '/tmp/demo-application', 0777, true);

    expect(is_dir(__DIR__ . '/tmp/demo-application'))->toBeTrue();
    //
});
