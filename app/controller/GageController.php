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

    var $xSize = 1400;
    var $ySize = 600;
    var $xCenter = 800;
    var $yCenter = 550;
    var $gageThick = 80;
    var $gageDia = 900; 
    var $image;

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    public function current_status_level()
    {

        $role = RoleFactory::GetRole($this->request->param('position'), new User($this->request->param('id')));

        // Create an image with the specified dimensions
        $this->image = imageCreate($this->xSize, $this->ySize);

        $white          = imageColorAllocate($this->image, 255,255,255);
        $lightgrey      = imageColorAllocate($this->image, 0xED, 0xEB, 0xEB);
        $semilightgrey  = imageColorAllocate($this->image, 192, 192, 192);
        $grey           = imageColorAllocate($this->image, 127,127,127);
        $black          = imageColorAllocate($this->image, 0,0,0);

        $ConsulColor =      imageColorAllocate($this->image, 0x52, 0x53, 0x57);
        $DiplomatColor =    imageColorAllocate($this->image, 0xBC, 0x26, 0x28);
        $AmbassadorColor =  imageColorAllocate($this->image, 0x54, 0x6E, 0x22);
        $PremierColor =     imageColorAllocate($this->image, 0xB4, 0x7C, 0x37);

        imageFilledRectangle($this->image, 0, 0, 800, 800, $white);

        $percent1 = round(12000 / 50000 * 100);
        $percent2 = round(22000 / 50000 * 100);
        $percent3 = round(27000 / 50000 * 100);
        $percent4 = round(38000 / 50000 * 100);

        $complete        = $this->request->param('complete');
        $completePercent = round($this->request->param('complete') / 50000 * 100);
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

        $this->_needle($completePercent, $grey, $white);

        putenv('GDFONTPATH=' . realpath('.'));

        $textX = $this->xCenter-100;
        if (!$complete) {            
            $textX = $this->xCenter-15;
        }
        imagefttext ( $this->image, $size=48, $angle=0, $x=$textX, $y=$this->yCenter-45, $black,      'arialbd.ttf', number_format($complete,0,'.',','));

        $angle1 = 90-(($percent1 + $percent2) /2 * 1.8);
        $angle2 = 90-(($percent2 + $percent3) /2 * 1.8);
        $angle3 = 90-(($percent3 + $percent4) /2 * 1.8);
        $angle4 = 90-(($percent4 + 100) /2 * 1.8);

        // grey outer
        imagefttext ( $this->image, $size=18, $angle1, $x=$this->xCenter -280, $y= $this->yCenter -393, $grey,  'arialbd.ttf', 'CONSUL');
        imagefttext ( $this->image, $size=18, $angle2, $x=$this->xCenter -75, $y= $this->yCenter -475, $grey,  'arialbd.ttf', 'DIPLOMAT');
        imagefttext ( $this->image, $size=18, $angle3, $x=$this->xCenter +140, $y= $this->yCenter -465, $grey, 'arialbd.ttf', 'AMBASSADOR');
        imagefttext ( $this->image, $size=18, $angle4, $x=$this->xCenter +420, $y= $this->yCenter -230, $grey, 'arialbd.ttf', 'PREMIER');

        // Legend text
        imagefttext ( $this->image, $size=24, $angle=0, $x=80, $y=80, $black,  'arialbd.ttf', 'CONSUL');
        imagefttext ( $this->image, $size=24, $angle=0, $x, $y+40, $black,  'arialbd.ttf', 'DIPLOMAT');
        imagefttext ( $this->image, $size=24, $angle=0, $x, $y+80, $black, 'arialbd.ttf', 'AMBASSADOR');
        imagefttext ( $this->image, $size=24, $angle=0, $x, $y+120, $black, 'arialbd.ttf', 'PREMIER');

        //Legend colors
        imagefilledpolygon ( $this->image, [$x1 = 40,$y1 = 60,       $x2 = 60,$y2 = $y1,    $x4 = 60,$y4 = $y2+20, $x3 = $x1, $y3 = $y4], $no_of_points = 4, $ConsulColor);
        imagefilledpolygon ( $this->image, [$x1,     $y1 = $y1+40,   $x2,     $y2 = $y2+40, $x4,     $y4 = $y4+40, $x3,       $y3=$y4],   $no_of_points = 4, $DiplomatColor);
        imagefilledpolygon ( $this->image, [$x1,     $y1 = $y1+40,   $x2,     $y2 = $y2+40, $x4,     $y4 = $y4+40, $x3,       $y3=$y4],   $no_of_points = 4, $AmbassadorColor);
        imagefilledpolygon ( $this->image, [$x1,     $y1 = $y1+40,   $x2,     $y2 = $y2+40, $x4,     $y4 = $y4+40, $x3,       $y3=$y4],   $no_of_points = 4, $PremierColor);

        // Set type of image and send the output
        header("Content-type: image/png");
        imagePng($this->image);

        imageDestroy($this->image);
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
        $angle = 180 + ($percent * 1.8);
        $lineThickness = 10;
        $lineLength = $this->gageDia;


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