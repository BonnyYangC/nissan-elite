<?php

namespace App\Console\Commands;

use App\Models\Guild\Events;
use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Csv\Statement;

class PreImportGuildEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pre-import:guild-events {filePath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pre import guild events from csv file';

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
     * @throws \League\Csv\Exception
     */
    public function handle()
    {

        $filePath = __DIR__.'/'.$this->argument('filePath');
        var_dump($filePath);

        $successCount = 0;

        if(file_exists($filePath)){
            \DB::table('guild_events')->delete();

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

                Events::factory()->create([
                    'type' => $type,
                    'member' => $record[0],
                    'dealer' => $record[1]
                ]);
                $successCount++;
            }

            echo 'Guild_events table has updated Success: '.$successCount.PHP_EOL;
        }
        else{
            echo 'File is not exists.'.PHP_EOL;
        }
    }
}
