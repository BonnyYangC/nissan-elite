<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PreImportJson extends Command
{   
    protected $signature = 'pre-import-json-stub';
    protected $data;
    protected $fileName;
    protected $connection;

    /**
     * Execute the console command.
     *
     * @return int
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
        $data = json_decode(Storage::disk('elite')->get($this->argument('theme').'/'.$this->fileName), true);

        $this->data = is_array($this->data) ? array_merge($this->data, $data) : $data;
    }

    protected function importData() { }
}
