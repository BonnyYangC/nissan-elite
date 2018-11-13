<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 14/11/18
 * Time: 9:16 AM
 */

namespace App\controller\backend;
use App\core\BaseController;
use App\models\nissan\Faq;
use Klein\Request;
use Klein\Response;

class FaqController extends BaseController
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * Load calendars
     */
    public function faq_index(){
        $this->dataForView['faqs']      = Faq::LoadAll();
        $this->render('backend/faq/index');
        return;
    }

    public function faq_new(){
        $this->dataForView['faq'] = new Faq();

        $this->dataForView['extra_css'][] = asset('redactor/redactor.min.css');
        $this->dataForView['extra_js'][] = asset('redactor/redactor.min.js');

        $this->render('backend/faq/edit');
        return;
    }

    public function faq_edit(){
        $this->dataForView['faq'] = new Faq($this->request->param('eid'));

        $this->dataForView['extra_css'][] = asset('redactor/redactor.min.css');
        $this->dataForView['extra_js'][] = asset('redactor/redactor.min.js');

        $this->render('backend/faq/edit');
        return;
    }

    public function faq_save(){
        $data = $this->request->paramsPost()->get('faq');

        $faq = new Faq($data['id']);

        foreach ($data as $fieldName=>$value) {
            $faq->$fieldName = $value;
        }

        if($faq->save()){
            session_flash('msg',['content'=>$faq->question.' has been updated successfully!','status'=>'success']);
        }else{
            session_flash('msg',['content'=>'System busy, please try again or contact IT person!','status'=>'danger']);
        }
        $this->response->redirect('/admin/faq-index');
        return;
    }

    public function faq_delete(){
        Faq::DB()->delete(Faq::TABLE_NAME,['id'=>$this->request->param('eid')]);
        session_flash('msg',['content'=>'A FAQ has been deleted successfully!','status'=>'success']);
        $this->response->redirect('/admin/faq-index');
        return;
    }
}