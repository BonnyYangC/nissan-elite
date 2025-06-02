<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Http\Request;

class NewsRepository {

    /**
     * @param Request $request
     */
    public function updateNews(Request $request) {
        $input = $request->input();
        if ($request->hasFile('image')) {
            $imagefileName = $request->image->getClientOriginalName();
            $request->image->storeAs('news/images', $imagefileName, 'elite');
            $input['image'] = $imagefileName;
        }
        if ($request->hasFile('pdf')) {
            $pdffileName = $request->pdf->getClientOriginalName();
            $request->pdf->storeAs('news/pdfs', $pdffileName, 'elite');
            $input['pdf'] = $pdffileName;
        }
        $this->update($input);
    }

    /**
     * @return mixed
     */
    public function load() {
        return News::orderBy('id', 'DESC')->get();
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
