<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CustomerImportService;

class CustomerImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from third party Data Provider';

    private $customerImportService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CustomerImportService $customerImportService)
    {
        $this->customerImportService = $customerImportService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param  \App\Support\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        $this->customerImportService->process();
        print("Import Success!\n");
    }
}