<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use League\Csv\Statement;

class PreImportCsv extends Command
{
    protected $signature = 'pre-import-csv-stub';
    protected $fileName;
    protected $data;


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
        $this->loadData();

        try {
            Model::unguard();
            DB::beginTransaction();
            $this->importData();
            DB::commit();
            var_dump("{$this->fileName} import finished");
        } catch (Throwable $ex) {
            var_dump("{$this->fileName} import failed: { $ex->getMessage() }");
            DB::rollBack();
            throw $ex;
        } finally{
            Model::reguard();
        }
    }

    private function loadData() {

        $file = __DIR__ . '/' . $this->fileName;
        if (file_exists($file)) {
            $csvReader = Reader::createFromPath($file,'r');
            $this->data = (new Statement())->process($csvReader);
        } else {
            echo 'File is not exists.'.PHP_EOL;
        }
    }

    protected function importData() { }
}
