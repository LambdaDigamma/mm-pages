<?php

namespace LambdaDigamma\MMPages\Commands;

use Illuminate\Console\Command;

class MMPagesCommand extends Command
{
    public $signature = 'mm-pages';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
