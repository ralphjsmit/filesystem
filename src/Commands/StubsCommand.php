<?php

namespace RalphJSmit\Stubs\Commands;

use Illuminate\Console\Command;

class StubsCommand extends Command
{
    public $signature = 'stubs';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
