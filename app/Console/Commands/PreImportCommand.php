<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PreImportCommand extends Command
{   
    protected $signature = 'pre-import-stub';
    protected $data;
    protected $fileName;

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
        $this->loadData(__DIR__.'/'.$this->fileName);

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

    /**
     * @param $fileName
     */
    private function loadData($fileName) {
        $data = json_decode(file_get_contents($fileName), true);
        $this->data = is_array($this->data) ? array_merge($this->data, $data) : $data;
    }

    /**
     *
     */
    protected function importData() { }
}
