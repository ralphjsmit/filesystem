<?php

namespace RalphJSmit\Stubs;

use RalphJSmit\Stubs\Commands\StubsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class StubsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('stubs')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_stubs_table')
            ->hasCommand(StubsCommand::class);
    }
}
