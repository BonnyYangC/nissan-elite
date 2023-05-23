<?php

namespace App\Console\Commands;

use App\Models\Guild\Events;
use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Csv\Statement;

class ImportGuildEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:guild-event {filePath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload guild events from csv file';

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

        $filePath = __DIR__.'/'.$this->argument('filePath');
        var_dump($filePath);

        $successCount = 0;

        if(file_exists($filePath)){
            $csvReader = Reader::createFromPath($filePath,'r');
            $records = (new Statement())->process($csvReader);
            $type = 1;
            foreach ($records as $lineNumber => $record) {
                if (strstr($record[0], 'PLATINUM MEMBERS')) {
                    //'PLATINUM MEMBERS (500,000+)'
                    $type = 1;
                    continue;
                } else if (strstr($record[0], 'GOLD MEMBERS')) {
                    //'PLATINUM MEMBERS (500,000+)'
                    $type = 2;
                    continue;
                } else if (strstr($record[0], 'LIFETIME MEMBERS')) {
                    //'LIFETIME MEMBERS - RETIRED'
                    $type = 3;
                    continue;
                } else if (!$record[0]) {
                    continue;
                }
                $model = new Events();
                $model->type = $type;
                $model->member = $record[0];
                $model->dealer = $record[1];
                $model->save();
            }

            echo 'Success: '.$successCount.PHP_EOL;
        }
        else{
            echo 'File is not exists.'.PHP_EOL;
        }
    }
}
