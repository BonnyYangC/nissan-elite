<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 1/8/18
 * Time: 1:07 PM
 *
 * This version is not in use, but has all the code to create the background images if they need to be updated
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

        $ytd = configuration('YEAR',2019);
        $dataForView = $role->getDashboardViewData($this->dataForView,$ytd);

        $max = $dataForView['statusChart']['max'];

        // Create an image with the specified dimensions
        $this->image = imagecreatetruecolor($this->xSize, $this->ySize);

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

        //background to white
        imageFilledRectangle($this->image, 0, 0, $this->xSize, $this->ySize, $white);

        $percent1 = round($dataForView['statusChart']['gageArray'][0][0]);
        $percent2 = round($dataForView['statusChart']['gageArray'][1][0]);
        $percent3 = round($dataForView['statusChart']['gageArray'][2][0]);
        $percent4 = round($dataForView['statusChart']['gageArray'][3][0]);

        $complete        = $this->request->param('complete');
        $completePercent = round($this->request->param('complete') / $max * 100);
        $completePercent = min(100, $completePercent);

        $this->_completionArc(0,         $percent1, $lightgrey,         $this->gageDia /4,  $this->gageDia /2); 
        $this->_completionArc($percent1, $percent2, $ConsulColor,       $this->gageDia /4,  $this->gageDia /2); 
        $this->_completionArc($percent2, $percent3, $DiplomatColor,     $this->gageDia /4,  $this->gageDia /2); 
        $this->_completionArc($percent3, $percent4, $AmbassadorColor,   $this->gageDia /4,  $this->gageDia /2); 
        $this->_completionArc($percent4, 101,       $PremierColor,      $this->gageDia /4,  $this->gageDia /2); 

        $this->_completionArc(0,         $percent1, $lightgrey,         $this->gageDia * .51,  $this->gageDia *.6); 
        $this->_completionArc($percent1, $percent2, $lightgrey,         $this->gageDia * .51,  $this->gageDia *.6); 
        $this->_completionArc($percent2, $percent3, $lightgrey,         $this->gageDia * .51,  $this->gageDia *.6); 
        $this->_completionArc($percent3, $percent4, $lightgrey,         $this->gageDia * .51,  $this->gageDia *.6); 
        $this->_completionArc($percent4, 101,       $lightgrey,         $this->gageDia * .51,  $this->gageDia *.6); 

        $this->_whiteDivider($percent1, $white); 
        $this->_whiteDivider($percent2, $white); 
        $this->_whiteDivider($percent3, $white); 
        $this->_whiteDivider($percent4, $white); 
        $this->_whiteDivider(101,       $white); 

        // the needle
        $this->_needle($completePercent, $grey, $white);

        // // Jo's grey arrow for first sector below consul   //start at 5% and finish 7% before consul, with 2% for arrowhead
        $this->_completionArc(3, $percent1-4, $grey,         $this->gageDia * .55,  $this->gageDia *.56); 
        
        // // arrowhead
        $arrowThickness = 20;
        $angle = 180-(($percent1 -0.5 -3) * 1.8);

        // // arrow point
        $x1 = $this->xCenter + cos(deg2rad($angle)) * $this->gageDia * 0.555;
        $y1 = $this->yCenter - sin(deg2rad($angle)) * $this->gageDia * 0.555;

        $arrowAngle = 145;

        $x2 = $x1 + cos( deg2rad($angle -90 + $arrowAngle )) * 70 ;
        $y2 = $y1 - sin( deg2rad($angle -90 + $arrowAngle )) * 70 ;
        $x3 = $x1 + cos( deg2rad($angle -90 - $arrowAngle )) * 70 ;
        $y3 = $y1 - sin( deg2rad($angle -90 - $arrowAngle )) * 70 ;
        imagefilledpolygon ( $this->image, [$x1,$y1, $x2,$y2, $x3,$y3], $no_of_points = 3, $grey );

        putenv('GDFONTPATH=' . realpath('.'));

        $angle1 = 90-(($percent1 + $percent2) /2 * 1.8);  // find the middle of ranges (average) to work out the angle to rotate the text
        $angle2 = 90-(($percent2 + $percent3) /2 * 1.8);
        $angle3 = 90-(($percent3 + $percent4) /2 * 1.8);
        $angle4 = 90-(($percent4 + 100) /2 * 1.8);

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

        // grey outer with text labels
        switch($pos) {  // I had to tweak these to position the text, depending on what percentage was the middle of these ranges
            case 'F':
            case 'R':
            case 'M':
                imagefttext ( $this->image, $size=36, $angle1, $x=$this->xCenter -560, $y= $this->yCenter -766, $grey, 'arialbd.ttf', 'CONSUL');
                imagefttext ( $this->image, $size=36, $angle2, $x=$this->xCenter -150, $y= $this->yCenter -930, $grey, 'arialbd.ttf', 'DIPLOMAT');
                imagefttext ( $this->image, $size=36, $angle3, $x=$this->xCenter +280, $y= $this->yCenter -910, $grey, 'arialbd.ttf', 'AMBASSADOR');
                imagefttext ( $this->image, $size=36, $angle4, $x=$this->xCenter +840, $y= $this->yCenter -450, $grey, 'arialbd.ttf', 'PREMIER');
                break;            
            case 'SA':    
            case 'PM':    
            case 'PS':    
            case 'SM':    
                imagefttext ( $this->image, $size=36, $angle1, $x=$this->xCenter -740, $y= $this->yCenter -586, $grey, 'arialbd.ttf', 'CONSUL');
                imagefttext ( $this->image, $size=36, $angle2, $x=$this->xCenter -290, $y= $this->yCenter -900, $grey, 'arialbd.ttf', 'DIPLOMAT');
                imagefttext ( $this->image, $size=36, $angle3, $x=$this->xCenter +370, $y= $this->yCenter -880, $grey, 'arialbd.ttf', 'AMBASSADOR');
                imagefttext ( $this->image, $size=36, $angle4, $x=$this->xCenter +870, $y= $this->yCenter -360, $grey, 'arialbd.ttf', 'PREMIER');
                break;
            case 'SC':    
            case 'C':    
                imagefttext ( $this->image, $size=36, $angle1, $x=$this->xCenter -510, $y= $this->yCenter -786, $grey, 'arialbd.ttf', 'CONSUL');
                imagefttext ( $this->image, $size=36, $angle2, $x=$this->xCenter -210, $y= $this->yCenter -920, $grey, 'arialbd.ttf', 'DIPLOMAT');
                imagefttext ( $this->image, $size=36, $angle3, $x=$this->xCenter +210, $y= $this->yCenter -930, $grey, 'arialbd.ttf', 'AMBASSADOR');
                imagefttext ( $this->image, $size=36, $angle4, $x=$this->xCenter +835, $y= $this->yCenter -460, $grey, 'arialbd.ttf', 'PREMIER');
                break;
            case 'I':    
                imagefttext ( $this->image, $size=36, $angle1, $x=$this->xCenter -620, $y= $this->yCenter -700, $grey, 'arialbd.ttf', 'CONSUL');
                imagefttext ( $this->image, $size=36, $angle2, $x=$this->xCenter -230, $y= $this->yCenter -910, $grey, 'arialbd.ttf', 'DIPLOMAT');
                imagefttext ( $this->image, $size=36, $angle3, $x=$this->xCenter +230, $y= $this->yCenter -910, $grey, 'arialbd.ttf', 'AMBASSADOR');
                imagefttext ( $this->image, $size=36, $angle4, $x=$this->xCenter +820, $y= $this->yCenter -450, $grey, 'arialbd.ttf', 'PREMIER');
                break;
        }

        $textX = $this->xCenter-100;
        if (!$complete) {            
            $textX = $this->xCenter-15;
        }
        // number to go with the needle
        imagefttext ( $this->image, $size=48, $angle=0, $x=$textX, $y=$this->yCenter-45, $black,      'arialbd.ttf', number_format($complete,0,'.',','));

        // // Legend text
        imagefttext ( $this->image, $size=48, $angle=0, $x=160, $y=160, $black,  'arialbd.ttf', 'CONSUL');
        imagefttext ( $this->image, $size=48, $angle=0, $x, $y+80, $black,  'arialbd.ttf', 'DIPLOMAT');
        imagefttext ( $this->image, $size=48, $angle=0, $x, $y+160, $black, 'arialbd.ttf', 'AMBASSADOR');
        imagefttext ( $this->image, $size=48, $angle=0, $x, $y+240, $black, 'arialbd.ttf', 'PREMIER');

        // //Legend colors
        imagefilledpolygon ( $this->image, [$x1 = 80,$y1 = 120,      $x2 = 120,$y2 = $y1,    $x4 = 120,$y4 = $y2+40, $x3 = $x1, $y3 = $y4], $no_of_points = 4, $ConsulColor);
        imagefilledpolygon ( $this->image, [$x1,     $y1 = $y1+80,   $x2,     $y2 = $y2+80, $x4,     $y4 = $y4+80, $x3,       $y3=$y4],   $no_of_points = 4, $DiplomatColor);
        imagefilledpolygon ( $this->image, [$x1,     $y1 = $y1+80,   $x2,     $y2 = $y2+80, $x4,     $y4 = $y4+80, $x3,       $y3=$y4],   $no_of_points = 4, $AmbassadorColor);
        imagefilledpolygon ( $this->image, [$x1,     $y1 = $y1+80,   $x2,     $y2 = $y2+80, $x4,     $y4 = $y4+80, $x3,       $y3=$y4],   $no_of_points = 4, $PremierColor);

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