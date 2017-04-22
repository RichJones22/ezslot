<?php

namespace App\Console\Commands;

use App\Services\SymbolsS;
use Illuminate\Console\Command;

class PerformanceSymbolsUnique extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optionsHouse:symbolsUnique';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Performance command to be run with Blackfire';
    /**
     * @var SymbolsS
     */
    private $symbolsS;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SymbolsS $symbolsS)
    {
        parent::__construct();
        $this->symbolsS = $symbolsS;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->symbolsS->symbolsUnique();
    }
}
