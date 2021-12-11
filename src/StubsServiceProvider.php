<?php

namespace RalphJSmit\Stubs;

use RalphJSmit\Stubs\Commands\StubsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class StubsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('stubs')
            ->hasCommand(StubsCommand::class);
    }
}
