<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Csv\Statement;
use Illuminate\Support\Facades\Hash;

class PreImportUsers extends Command
{
    use ImportTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pre-import:users {filePath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pre import users from csv file';

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
                if (!$this->isValid($record)) continue;
                $model = new User();
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

    private function isValid($row) {
        return isset($row['employee_code']);
    }
    
    private function buildData($row) {
        return [
            'employee_code'=>!($row['employee_code'] == 'NULL') ? $row['employee_code'] : null,
            'salutation'=>!($row['salutation'] == 'NULL') ? $row['salutation'] : null,
            'firstname'=>$row['firstname'],
            'lastname'=>$row['lastname'],
            'email'=>$row['email'],
            'mobile'=>!($row['mobile'] == 'NULL') ? $row['mobile'] : null,
            'date_birth'=>!($row['date_birth'] == '0000-00-00' || $row['date_birth'] == 'NULL') ? date('Y-m-d',$this->getStrtotime($row['date_birth'])) : null,
            'password' => Hash::make(strtoupper(trim($row['lastname'])).'1'),
            'dealer_code'=>!($row['dealer_code'] == 'NULL') ? $row['dealer_code'] : null,
            'position_code'=> !($row['position_code'] === 'N/A' || $row['position_code'] === '' || $row['position_code'] === 'NULL') ? $row['position_code'] : null,
            'dept'=>!($row['dept'] == 'NULL') ? $row['dept'] : null,
            'active'=>0,
            'date_created'=>!($row['date_created'] == 'NULL') ? date('Y-m-d',$this->getStrtotime($row['date_created'])) : null,
            'region_code'=>!($row['region_code'] == 'NULL') ? $row['region_code'] : null,
            'admin'=>$row['admin'],
        ];
    }
}
