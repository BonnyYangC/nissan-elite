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
    public function loadAll() {
        return Faq::get();
    }
        /**
     * @return
     */
    public function loadPublished() {
        return Faq::where('status','=','1')->get();
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
        if (isset($newData['sorting']) && is_int($newData['sorting'])) {
            $faq->sorting = $newData['sorting']; 
        } else {
            $faq->sorting = Faq::orderBy('sorting','desc')->value('sorting')+1;
        }
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
