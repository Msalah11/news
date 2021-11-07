<?php

namespace App\Console\Commands;

use App\Actions\NewsAction;
use Illuminate\Console\Command;

class DeleteNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all news older than 14 days';

    /**
     * Delete from period
     *
     * @var integer
     */
    private $period = 15;

    protected $newsAction;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NewsAction $newsAction)
    {
        parent::__construct();

        $this->newsAction = $newsAction;
    }

    public function handle()
    {
        $this->info('starting Deleting');
        if($this->newsAction->deleteByDate($this->period)) {
            return $this->info('Items Deleted Successfully');
        }

        $this->error('Items Delete Failed');
    }
}
