<?php

namespace App\Services;

use App\Models\Faq;

class FaqService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * @return
     */
    public function load() {
        return Faq::get();
    }

    /**
     * @param $newData
     * @return \App\core\Model|bool|string
     */
    public function update($newData) {
        if(!empty($newData['id'])){
            $faq = Faq::find($newData['id']);
        }else{
            $faq = new Faq();
        }
        $faq->question = $newData['question'];
        $faq->sorting = $newData['sorting'];
        $faq->status = $newData['status'];
        $faq->answer = $newData['answer'];

        return $faq->save();
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
