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
    var $xCenter = 700;
    var $yCenter = 500;
    var $gageThick = 80;
    var $gageDia = 800; 
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

        imagearc($this->image, $this->xCenter, $this->yCenter, $this->gageDia,                  $height=$this->gageDia,                  $start=180, $end=0, $lightgrey); 
        imagearc($this->image, $this->xCenter, $this->yCenter, $this->gageDia+$this->gageThick, $height=$this->gageDia+$this->gageThick, $start=180, $end=0, $lightgrey); 

        imageline ( $this->image, $x1 = 260 , $y1 = $this->yCenter , $x2 = 300 , $y2 = $this->yCenter , $lightgrey );

        imageline ( $this->image, $x1 = $this->xCenter + 400 , $y1 = $this->yCenter , $x2 = $this->xCenter + 440 , $y2 = $this->yCenter , $lightgrey );


        //imageFill( $this->image, $x = $this->xCenter - ($this->gageDia /2) + 2 , $this->yCenter -1, $grey);
        imageFill( $this->image, $x = 270 , 498, $lightgrey);

        $this->_radial ($percent = (12000 / 50000) * 100, $startLength = 0, $endLength = 400, $semilightgrey);
        $this->_radial ($percent = (22000 / 50000) * 100, $startLength = 0, $endLength = 400, $semilightgrey);
        $this->_radial ($percent = (27000 / 50000) * 100, $startLength = 0, $endLength = 400, $semilightgrey);
        $this->_radial ($percent = (38000 / 50000) * 100, $startLength = 0, $endLength = 400, $semilightgrey);

        $complete        = $this->request->param('complete');
        $completePercent = round($this->request->param('complete') / 50000 * 100);
        $completePercent = min(100, $completePercent);

        $completeColor = $black;
        if ($complete > 12000) $completeColor = $ConsulColor;
        if ($complete > 22000) $completeColor = $DiplomatColor;
        if ($complete > 27000) $completeColor = $AmbassadorColor;
        if ($complete > 38000) $completeColor = $PremierColor;

        putenv('GDFONTPATH=' . realpath('.'));
        if ($complete) {
            $this->_completionArc($completePercent, $completeColor);
            imagefttext ( $this->image , $size=48, $angle=0, $x=600 , $y=460 , $black ,      'arialbd.ttf' , number_format($complete,0,'.',','));

        } else {
            imagefttext ( $this->image , $size=48, $angle=0, $x=686 , $y=460 , $black ,      'arialbd.ttf' , number_format($complete,0,'.',','));
        }

        $this->_needle($completePercent, $grey);

        imagefttext ( $this->image , $size=24, $angle=0, $x=260 , $y=180 , $ConsulColor ,        'arialbd.ttf' , 'CONSUL');
        imagefttext ( $this->image , $size=24, $angle=0, $x=500 , $y=60 , $DiplomatColor ,      'arialbd.ttf' , 'DIPLOMAT');
        imagefttext ( $this->image , $size=24, $angle=0, $x=760 , $y=60 , $AmbassadorColor ,    'arialbd.ttf' , 'AMBASSADOR');
        imagefttext ( $this->image , $size=24, $angle=0, $x=1050 , $y=180 , $PremierColor ,       'arialbd.ttf' , 'PREMIER');


        // Set type of image and send the output
        header("Content-type: image/png");
        imagePng($this->image);

        imageDestroy($this->image);
    }

    private function _radial($percent, $startLength, $endLength, $color) {
        $angle = 180 + ($percent * 1.8);

        $x1 = $this->xCenter + cos($angle * 3.1416 / 180) * $startLength;
        $y1 = $this->yCenter + sin($angle * 3.1416 / 180) * $startLength;

        $x2 = $this->xCenter + cos($angle * 3.1416 / 180) * $endLength;
        $y2 = $this->yCenter + sin($angle * 3.1416 / 180) * $endLength;

        imageline ( $this->image, $x1, $y1, $x2, $y2, $color);
    }

    private function _completionArc ($percent, $color) {
        $start = 180;
        $end = 180 + (($percent+.5) * 1.8);

        imagearc($this->image, $this->xCenter, $this->yCenter, $this->gageDia,                  $height=$this->gageDia,                  $start=180, $end, $color); 
        imagearc($this->image, $this->xCenter, $this->yCenter, $this->gageDia+$this->gageThick, $height=$this->gageDia+$this->gageThick, $start=180, $end, $color); 

        $this->_radial( $percent,     $this->gageDia/2, ($this->gageDia+$this->gageThick) /2, $color);
        $this->_radial( $percent+.02, $this->gageDia/2, ($this->gageDia+$this->gageThick) /2, $color);  // to stop the fill leaking
        $this->_radial( $percent+.05, $this->gageDia/2, ($this->gageDia+$this->gageThick) /2, $color);  // to stop the fill leaking
        $this->_radial( $percent+.07, $this->gageDia/2, ($this->gageDia+$this->gageThick) /2, $color);  // to stop the fill leaking

        //imagefilledellipse ( $this->image , 286 , 496 , 5 ,5 , $color ) ;
        imageFill( $this->image, $x = 286, 496, $color);
    }

    private function _needle ($percent, $color) {
        $angle = 180 + ($percent * 1.8);
        $x1 = $this->xCenter + cos($angle * 3.1416 / 180) * (($this->gageDia -5) /2) ;  // -5 slightly not touching looks better
        $y1 = $this->yCenter + sin($angle * 3.1416 / 180) * (($this->gageDia -5) /2) ;

        $x2 = $this->xCenter + cos(($angle-4) * 3.1416 / 180) * (($this->gageDia -40)/2) ;
        $y2 = $this->yCenter + sin(($angle-4) * 3.1416 / 180) * (($this->gageDia -40)/2) ;

        $x3 = $this->xCenter + cos(($angle+4) * 3.1416 / 180) * (($this->gageDia -40)/2) ;
        $y3 = $this->yCenter + sin(($angle+4) * 3.1416 / 180) * (($this->gageDia -40)/2) ;

        imagefilledpolygon ( $this->image , [$x1,$y1, $x2,$y2, $x3,$y3] , 3 , $color );
    }

}