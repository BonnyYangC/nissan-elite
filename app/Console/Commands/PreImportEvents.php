<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Csv\Statement;

class PreImportEvents extends Command
{
    use ImportTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pre-import:events {filePath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pre import nissan events from csv file';

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
            $csvReader->setHeaderOffset(0);
            $records = (new Statement())->process($csvReader);
            foreach ($records as $lineNumber => $record) {
                $model = new Event();
                $data = $this->buildData($record);
                foreach ($data as $fieldName => $value) {
                    $model->$fieldName = $value;
                }
                $model->save();
                $successCount++;
            }

            echo 'Success: '.$successCount.PHP_EOL;
        }
        else{
            echo 'File is not exists.'.PHP_EOL;
        }
    }

    private function buildData($row) {
        return [
            'title' => $row['title'],
            'start' => $row['datestamp'],// date('Y-m-d',$this->getStrtotime($row['start'])),
            'end' => $row['dateend'], //date('Y-m-d',$this->getStrtotime($row['finish'])),
            'description' => $row['description'],
            'incentive' => $row['incentive_id'] == '0' ? null : $row['incentive_id'],
            'region' => $row['region'],
            'created_at' => !($row['created_at'] == 'NULL' || !isset($row['created_at']) || $row['created_at'] == '') ? $row['created_at'] : null,
            'updated_at' => !($row['updated_at'] == 'NULL' || !isset($row['updated_at']) || $row['updated_at'] == '') ? $row['updated_at'] : null,
        ];
    }
}
