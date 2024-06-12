<?php

namespace App\Console\Commands;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class PreImportFaqs extends PreImportJson
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pre-import:faqs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pre import faqs from json file';
    protected $fileName = 'faqs.json';

    /**
     *
     */
    protected function importData() {
        DB::table('faqs')->where('year', '=', config('elite.YEAR'))->delete();
        $faqs = $this->data['faqs'];
        foreach ($faqs as $q) {
            Faq::factory()->create($q);
        }
    }
}
