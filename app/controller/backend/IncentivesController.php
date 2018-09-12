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
}