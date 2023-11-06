<?php

namespace App\Console\Commands;

use App\Http\Controllers\Traits\MyImportManager;
use Barryvdh\TranslationManager\Manager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;


class MenuImport extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:import';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import translations for menu';

    /** @var \Barryvdh\TranslationManager\Manager */
    protected $manager;

    public function __construct(MyImportManager $manager)
    {
        $this->manager = $manager;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $counter = $this->manager->importTranslationsFile(true);
        $this->info('Done importing, processed '.$counter.' items!');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['replace', 'R', InputOption::VALUE_NONE, 'Replace existing keys'],
        ];
    }
}
