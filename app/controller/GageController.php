<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 1/8/18
 * Time: 1:07 PM
 */

namespace App\controller;

use App\core\BaseController;
use App\core\JsonBuilder;
use App\models\Company;
use App\models\role\status\FinanceControllerStatus;
use App\models\role\status\FiStatus;
use App\models\role\status\GageStatus;
use App\models\role\status\PartsSalesRepStatus;
use App\models\role\status\RetailSalesConsultantStatus;
use App\models\role\status\SalesManagerStatus;
use App\models\role\status\ServiceAdviserStatus;
use App\models\role\status\ServiceManagerStatus;
use App\models\role\status\StockControllerStatus;
use App\models\utils\RoleFactory;

use Klein\Request;
use Klein\Response;
use App\models\User;
use App\models\nissan\Ranking;
use League\Csv\Writer;

class GageController extends BaseController
{

    var $xSize = 2800;
    var $ySize = 1200;
    var $xCenter = 1600;
    var $yCenter = 1100;
    var $gageThick = 80;
    var $gageDia = 1800; 
    var $image;

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    public function current_status_level()
    {

        ini_set ('display_errors', 1);

        $role = RoleFactory::GetRole($pos = $this->request->param('position'), new User($this->request->param('id')));

        $ytd = env('YEAR',2018);
        $dataForView = $role->getDashboardViewData($this->dataForView,$ytd);

        $max = $dataForView['statusChart']['max'];

        switch($pos) {  // I had to tweak these to position the text, depending on what percentage was the middle of these ranges
            case 'F':
            case 'R':
            case 'M':
                $this->image = imagecreatefrompng('./graph-back_frm.png');
                break;            
            case 'SA':    
            case 'PM':    
            case 'PS':    
            case 'SM':    
                $this->image = imagecreatefrompng('graph-back_sa_pm_ps_sm.png');
                break;
            case 'SC':    
            case 'C':    
                $this->image = imagecreatefrompng('graph-back_sc_c.png');
                break;
            case 'I':    
                $this->image = imagecreatefrompng('graph-back_i.png');
                break;
        }

        $white          = imageColorAllocate($this->image, 255,255,255);
        $lightgrey      = imageColorAllocate($this->image, 0xED, 0xEB, 0xEB);
        $semilightgrey  = imageColorAllocate($this->image, 192, 192, 192);
        $grey           = imageColorAllocate($this->image, 127,127,127);
        $black          = imageColorAllocate($this->image, 0,0,0);

        $cc = $dataForView['statusChart']['gageArray'][0][1];
        $dc = $dataForView['statusChart']['gageArray'][1][1];
        $ac = $dataForView['statusChart']['gageArray'][2][1];
        $pc = $dataForView['statusChart']['gageArray'][3][1];

        // create the colors from hex triplets
        $ConsulColor =      imageColorAllocate($this->image, hexdec(substr($cc,1,2)), hexdec(substr($cc,3,2)), hexdec(substr($cc,5,2)));
        $DiplomatColor =    imageColorAllocate($this->image, hexdec(substr($dc,1,2)), hexdec(substr($dc,3,2)), hexdec(substr($dc,5,2)));
        $AmbassadorColor =  imageColorAllocate($this->image, hexdec(substr($ac,1,2)), hexdec(substr($ac,3,2)), hexdec(substr($ac,5,2)));
        $PremierColor =     imageColorAllocate($this->image, hexdec(substr($pc,1,2)), hexdec(substr($pc,3,2)), hexdec(substr($pc,5,2)));

        $complete        = $this->request->param('complete');
        $completePercent = round($this->request->param('complete') / $max * 100);
        $completePercent = min(100, $completePercent);

        // the needle
        $this->_needle($completePercent, $grey, $white);

        $angle = 180-(($percent1 -0.5 -3) * 1.8);

        putenv('GDFONTPATH=' . realpath('.'));

        $fo = fopen('tempfile.png', 'w');
        imagePng($this->image, 'tempfile.png');
        imageDestroy($this->image);
        fclose($fo);


        // save image, open in Imagick, blur the image - to removed the jagged edges on the diagonal lines
        if (class_exists('Imagick')) {
            $file = fopen('tempfile.png', 'r');
            $im = new \Imagick();
            $im->readImageFile($file);
            $im->blurImage(3,3);        
            $im->writeImage('tempfile.png');
            $im->writeImage('tempfile2.png');
        }
        
        $this->image = imagecreatefrompng('tempfile.png');

        $textX = $this->xCenter-100;
        if (!$complete) {            
            $textX = $this->xCenter-15;
        }
        // number to go with the needle
        imagefttext ( $this->image, $size=48, $angle=0, $x=$textX, $y=$this->yCenter-45, $black,      'arialbd.ttf', number_format($complete,0,'.',','));

        // Set type of image and send the output
        header("Content-type: image/png");

        imagePng($this->image);


    }

    private function _radial($percent, $startLength, $endLength, $color) {
        $angle = 180 + ($percent * 1.8);

        $x1 = $this->xCenter + cos(deg2rad($angle)) * -$startLength;
        $y1 = $this->yCenter + sin(deg2rad($angle)) * $startLength;

        $x2 = $this->xCenter + cos(deg2rad($angle)) * -$endLength;
        $y2 = $this->yCenter + sin(deg2rad($angle)) * $endLength;

        imageline ( $this->image, $x1, $y1, $x2, $y2, $color);
    }

    private function _completionArc ($startPercent, $endPercent, $color, $innerRad, $outerRad) {
        $startAngle = round (180 - $startPercent * 1.8);
        $endAngle   = round (180 - $endPercent * 1.8);

        $x1 = $this->xCenter + cos(deg2rad($startAngle)) * $outerRad;
        $y1 = $this->yCenter - sin(deg2rad($startAngle)) * $outerRad;

        $x2 = $this->xCenter + cos(deg2rad($startAngle)) * $innerRad; 
        $y2 = $this->yCenter - sin(deg2rad($startAngle)) * $innerRad;

        $polys = [$x1, $y1];

        // back array is the inner arc, and reversed below
        $back = [$y2, $x2]; // reverse order, because we are going to reverse this

        for ($i = 1; $i <= ($startAngle - $endAngle); $i++) {
            $angle = $startAngle - $i;

            $x3 = $this->xCenter + cos(deg2rad($angle)) * $outerRad ;
            $y3 = $this->yCenter - sin(deg2rad($angle)) * $outerRad ;

            $polys[] = $x3;
            $polys[] = $y3;


            $x4 = $this->xCenter + cos(deg2rad($angle)) * $innerRad;
            $y4 = $this->yCenter - sin(deg2rad($angle)) * $innerRad;

            $back[] = $y4;
            $back[] = $x4;
        }

        $polys = array_merge($polys, array_reverse($back));

        imagefilledpolygon ( $this->image, $polys, count($polys) /2, $color );
    }

    private function _needle ($percent, $color, $colorSpindle) {
        $angle = 180 + ($percent * 1.8);
        $x1 = $this->xCenter + cos(deg2rad($angle)) * $this->gageDia /2 * 0.55 ; 
        $y1 = $this->yCenter + sin(deg2rad($angle)) * $this->gageDia /2 * 0.55 ;

        $needleThickness = 80;

        $x2 = $this->xCenter + cos( deg2rad($angle-90)) * $needleThickness /2 ;
        $y2 = $this->yCenter + sin( deg2rad($angle-90)) * $needleThickness /2 ;

        $x3 = $this->xCenter + cos( deg2rad($angle+90)) * $needleThickness /2 ;
        $y3 = $this->yCenter + sin( deg2rad($angle+90)) * $needleThickness /2 ;

        imagefilledpolygon ( $this->image, [$x1,$y1, $x2,$y2, $x3,$y3], $no_of_points = 3, $color );

        imagefilledarc( $this->image, $this->xCenter, $this->yCenter, $needleThickness,   $needleThickness,   0, 360, $color, IMG_ARC_EDGED);
        imagefilledarc( $this->image, $this->xCenter, $this->yCenter, $needleThickness/2.5, $needleThickness/2.5, 0, 360, $colorSpindle, IMG_ARC_EDGED);
    }

    // white line to leave a little clearance between colored backgrounds
    private function _whiteDivider ($percent, $color) {
        $angle = round(180 + ($percent * 1.8));
        $lineThickness = 10;
        $lineLength = $this->gageDia /1.666;


        $x1 = $this->xCenter + cos( deg2rad($angle-90) ) * $lineThickness /2 ;
        $y1 = $this->yCenter + sin( deg2rad($angle-90) ) * $lineThickness /2 ;

        $x2 = $this->xCenter + cos( deg2rad($angle+90) ) * $lineThickness /2 ;
        $y2 = $this->yCenter + sin( deg2rad($angle+90) ) * $lineThickness /2 ;

        $x3 = $x1 + cos( deg2rad($angle)) * $lineLength ;
        $y3 = $y1 + sin( deg2rad($angle)) * $lineLength ;

        $x4 = $x2 + cos( deg2rad($angle)) * $lineLength ;
        $y4 = $y2 + sin( deg2rad($angle)) * $lineLength ;

        imagefilledpolygon ( $this->image, [$x2,$y2, $x1,$y1, $x3,$y3, $x4,$y4], $no_of_points = 4, $color );
    }
}