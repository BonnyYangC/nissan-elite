<?php

namespace App\Console\Commands;

use App\Models\Dealer;
use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Csv\Statement;

class PreImportDealers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pre-import:dealers {filePath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pre import dealers from csv file';

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
                $model = new Dealer();
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
            'code' => $row['code'],
            'name' => $row['name'],
            'address' => $row['address'],
            'suburb' => $row['suburb'],
            'state' => $row['state'],
            'postcode' => $row['postcode'],
            'country' => !($row['country'] == 'NULL') ? $row['country'] : null,
            'phone' => $row['phone'],
            'fax' => $row['fax'],
            'region' => $row['region'],
            'region_code' => $row['region_code'],
            'category' => $row['category'],
            'category_code' => $row['category_code'],
            'active' => 0,
        ];
    }
}
