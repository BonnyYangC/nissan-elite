<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Http\Request;

class NewsService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * @param Request $request
     */
    public function updateNews(Request $request) {
        $input = $request->input();
        if ($request->hasFile('image')) {
            $imagefileName = $request->file('image')->getClientOriginalName();
            $imageFile = $request->file('image')->storeAS('image', $imagefileName, 'public');
            rename(storage_path('app/public/'.$imageFile), public_path('images/news/images/'.$imagefileName));
            $input['image'] = $imagefileName;
        }
        if ($request->hasFile('pdf')) {
            $pdffileName = $request->file('pdf')->getClientOriginalName();
            $pdfFile = $request->file('pdf')->storeAS('image', $pdffileName, 'public');
            rename(storage_path('app/public/'.$pdfFile), public_path('images/news/pdfs/'.$pdffileName));
            $input['pdf'] = $pdffileName;
        }
        $this->update($input);
    }

    /**
     * @return mixed
     */
    public function load() {
        return News::get();
    }

    /**
     * @param $newData
     * @return \App\core\Model|bool|string
     */
    public function update($newData) {
        if(!empty($newData['id'])){
            $news = News::find($newData['id']);
        }else{
            $news = new News();
        }
        $news->title = $newData['title'];
        if (isset($newData['image'])) {
            $news->image = $newData['image'];
        }
        if (isset($newData['pdf'])) {
            $news->pdf = $newData['pdf'];
        }

        return $news->save();
    }

    /**
     * @param News $news
     * @return bool|null
     * @throws \Exception
     */
    public function delete(News $news) {
        return $news->delete();
    }
}
