<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 11/9/18
 * Time: 2:53 PM
 */

namespace App\controller\backend;
use Klein\Request;
use Klein\Response;
use App\core\BaseController;
use App\models\nissan\Incentives;
use App\lib\utils\FileUploader;

class IncentivesController extends BaseController
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * Load calendars
     */
    public function incentives_index(){
        $incentives = Incentives::LoadAll();
        $this->dataForView['incentives'] = $incentives;
        $this->render('backend/incentives/index');
        return;
    }

    public function incentive_new(){
        $incentive = new Incentives();
        $this->dataForView['incentive'] = $incentive;
        $this->render('backend/incentives/edit');
        return;
    }

    public function incentive_edit(){
        $incentive = new Incentives($this->request->param('eid'));
        $this->dataForView['incentive'] = $incentive;
        $this->render('backend/incentives/edit');
        return;
    }

    public function incentive_save(){
        $data = $this->request->paramsPost()->get('incentive');

        $uploader = new FileUploader($this->request);
        $imagePath = env('ROOT_PATH').'/public_html'.Incentives::IMAGE_FILE_PATH;
        $filePath = $uploader->store('image',$imagePath);
        if(!empty($filePath)){
            $tmp = explode('/',$filePath);
            $data['image'] = $tmp[count($tmp) - 1];
        }

        $pdfPath = env('ROOT_PATH').'/public_html'.Incentives::PDF_FILE_PATH;
        $filePath2 = $uploader->store('pdf',$pdfPath);
        if(!empty($filePath2)){
            $tmp = explode('/',$filePath2);
            $data['pdf'] = $tmp[count($tmp) - 1];
        }


        $incentive = new Incentives($data['id']);

        foreach ($data as $fieldName=>$value) {
            $incentive->$fieldName = $value;
        }

        $incentive->save();
        $this->response->redirect('/admin/incentives-index');
        return;
    }
}