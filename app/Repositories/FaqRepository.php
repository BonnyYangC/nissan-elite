<?php

namespace App\Repositories;

use App\Models\Faq;

class FaqRepository {

    /**
     * @return
     */
    public function loadAll() {
        return Faq::where('year', config('elite.YEAR'))->get();
    }

    /**
     * @return
     */
    public function loadPublished() {
        return Faq::where('year', config('elite.YEAR'))->where('status','=','1')->get();
    }

    /**
     * @param $newData
     * @return \App\core\Model|bool|string
     */
    public function store($newData) {

        return Faq::factory()->create([
            'question' => $newData['question'],
            'sorting' => Faq::orderBy('sorting','desc')->value('sorting')+1,
            'status' => $newData['status'],
            'answer' => $newData['answer'],
        ]);
    }

    /**
     * @param $newData
     * @return \App\core\Model|bool|string
     */
    public function update($newData) {
        return Faq::find($newData['id'])->update([
            'question' => $newData['question'],
            'status' => $newData['status'],
            'answer' => $newData['answer'],
        ]);
    }

    /**
     * @param Faq $faq
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Faq $faq) {
        return $faq->delete();
    }
}
