<?php

namespace App\Console\Commands;

use App\Models\Mpesapayment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Deleteemptympesatransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleteempty:mpesatransaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // delete null mpesa transactions
        Mpesapayment::where('mpesatransaction_id',null)->delete();

        // show the delete message in the log file
        Log::info('Null Mpesa Transaction Records have been deleted');
    }
}
