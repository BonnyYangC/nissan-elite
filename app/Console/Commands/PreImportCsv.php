<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Statement;

class PreImportCsv extends Command
{
    protected $signature = 'pre-import-csv-stub';
    protected $fileName;
    protected $data;
    protected $connection;


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
            $this->connection = DB::connection('mysql_'.$this->argument('theme'));
            $this->connection->beginTransaction();
            $this->importData();
            $this->connection->commit();
            var_dump("{$this->fileName} import finished");
        } catch (Throwable $ex) {
            var_dump("{$this->fileName} import failed: { $ex->getMessage() }");
            $this->connection->rollBack();
            throw $ex;
        } finally{
            Model::reguard();
        }
    }

    private function loadData() {

        $file = Storage::disk('elite')->path($this->argument('theme').'/'.$this->fileName);
        if (file_exists($file)) {
            $csvReader = Reader::createFromPath($file,'r');
            $this->data = (new Statement())->process($csvReader);
        } else {
            echo 'File is not exists.'.PHP_EOL;
        }
    }

    protected function importData() { }
}
