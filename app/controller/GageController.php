<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 1/8/18
 * Time: 1:07 PM
 */

namespace App\controller;

use App\core\BaseController;
use App\models\utils\RoleFactory;

use Klein\Request;
use Klein\Response;
use App\models\User;
use App\models\utils\LifetimeUtil;

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

        ini_set('display_errors', 1);

        $role = RoleFactory::GetRole($pos = $this->request->param('position'), new User($this->request->param('id')));

        $ytd = configuration('YEAR', 2019);
        $dataForView = $role->getDashboardViewData($this->dataForView, $ytd);
        $fontFile = 'arialbd.ttf';
        
        $max = $dataForView['statusChart']['max'];

        // Create an image with the specified dimensions
        $this->image = imagecreatetruecolor($this->xSize, $this->ySize);

        $white          = imageColorAllocate($this->image, 255, 255, 255);
        $lightgrey      = imageColorAllocate($this->image, 0xED, 0xEB, 0xEB);
        $semilightgrey  = imageColorAllocate($this->image, 192, 192, 192);
        $grey           = imageColorAllocate($this->image, 127, 127, 127);
        $black          = imageColorAllocate($this->image, 0, 0, 0);

        $statusLevel1Color = $dataForView['statusChart']['gageArray'][0][1];
        $statusLevel2Color = $dataForView['statusChart']['gageArray'][1][1];
        $statusLevel3Color = $dataForView['statusChart']['gageArray'][2][1];
        $statusLevel4Color = $dataForView['statusChart']['gageArray'][3][1];

        // create the colors from hex triplets
        $statusLevel1ArcColor =      imageColorAllocate($this->image, hexdec(substr($statusLevel1Color, 1, 2)), hexdec(substr($statusLevel1Color, 3, 2)), hexdec(substr($statusLevel1Color, 5, 2)));
        $statusLevel2ArcColor =    imageColorAllocate($this->image, hexdec(substr($statusLevel2Color, 1, 2)), hexdec(substr($statusLevel2Color, 3, 2)), hexdec(substr($statusLevel2Color, 5, 2)));
        $statusLevel3ArcColor =  imageColorAllocate($this->image, hexdec(substr($statusLevel3Color, 1, 2)), hexdec(substr($statusLevel3Color, 3, 2)), hexdec(substr($statusLevel3Color, 5, 2)));
        $statusLevel4ArcColor =     imageColorAllocate($this->image, hexdec(substr($statusLevel4Color, 1, 2)), hexdec(substr($statusLevel4Color, 3, 2)), hexdec(substr($statusLevel4Color, 5, 2)));

        //background to white
        imageFilledRectangle($this->image, 0, 0, $this->xSize, $this->ySize, $white);

        $percent1 = round($dataForView['statusChart']['gageArray'][0][0]);
        $percent2 = round($dataForView['statusChart']['gageArray'][1][0]);
        $percent3 = round($dataForView['statusChart']['gageArray'][2][0]);
        $percent4 = round($dataForView['statusChart']['gageArray'][3][0]);

        $complete        = $this->request->param('complete');
        $completePercent = round($this->request->param('complete') / $max * 100);
        $completePercent = min(100, $completePercent);

        drawArc($this->image, $this->xCenter, $this->yCenter, 0,         $percent1, $lightgrey,         $this->gageDia / 4,  $this->gageDia / 2);
        drawArc($this->image, $this->xCenter, $this->yCenter, $percent1, $percent2, $statusLevel1ArcColor,       $this->gageDia / 4,  $this->gageDia / 2);
        drawArc($this->image, $this->xCenter, $this->yCenter, $percent2, $percent3, $statusLevel2ArcColor,     $this->gageDia / 4,  $this->gageDia / 2);
        drawArc($this->image, $this->xCenter, $this->yCenter, $percent3, $percent4, $statusLevel3ArcColor,   $this->gageDia / 4,  $this->gageDia / 2);
        drawArc($this->image, $this->xCenter, $this->yCenter, $percent4, 101,       $statusLevel4ArcColor,      $this->gageDia / 4,  $this->gageDia / 2);

        drawArc($this->image, $this->xCenter, $this->yCenter, 0,         $percent1, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        drawArc($this->image, $this->xCenter, $this->yCenter, $percent1, $percent2, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        drawArc($this->image, $this->xCenter, $this->yCenter, $percent2, $percent3, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        drawArc($this->image, $this->xCenter, $this->yCenter, $percent3, $percent4, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        drawArc($this->image, $this->xCenter, $this->yCenter, $percent4, 101,       $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);

        whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent1, $white);
        whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent2, $white);
        whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent3, $white);
        whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent4, $white);
        whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, 101,       $white);

        // the needle
        needleOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $completePercent, $grey, $white);

        // // Jo's grey arrow for first sector below consul   //start at 5% and finish 7% before consul, with 2% for arrowhead
        drawArc($this->image, $this->xCenter, $this->yCenter, 3, $percent1 - 4, $grey,         $this->gageDia * .55,  $this->gageDia * .56);

        // // arrowhead
        $arrowThickness = 20;
        $angle = 180 - (($percent1 - 0.5 - 3) * 1.8);

        // // arrow point
        $x1 = $this->xCenter + cos(deg2rad($angle)) * $this->gageDia * 0.555;
        $y1 = $this->yCenter - sin(deg2rad($angle)) * $this->gageDia * 0.555;

        $arrowAngle = 145;

        $x2 = $x1 + cos(deg2rad($angle - 90 + $arrowAngle)) * 70;
        $y2 = $y1 - sin(deg2rad($angle - 90 + $arrowAngle)) * 70;
        $x3 = $x1 + cos(deg2rad($angle - 90 - $arrowAngle)) * 70;
        $y3 = $y1 - sin(deg2rad($angle - 90 - $arrowAngle)) * 70;
        imagefilledpolygon($this->image, [$x1, $y1, $x2, $y2, $x3, $y3], $no_of_points = 3, $grey);

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
            $im->blurImage(3, 3);
            $im->writeImage('tempfile.png');
            $im->writeImage('tempfile2.png');
        }

        $this->image = imagecreatefrompng('tempfile.png');

        // grey outer with text labels
        $statusLevel1Text = $dataForView['statusChart']['gageArray'][0][2];
        $statusLevel2Text = $dataForView['statusChart']['gageArray'][1][2];
        $statusLevel3Text = $dataForView['statusChart']['gageArray'][2][2];
        $statusLevel4Text = $dataForView['statusChart']['gageArray'][3][2];

        $s1 = round(180 + $percent1 * 1.788);
        $s2 = round(180 + $percent2 * 1.8);
        textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s1, $s2, $grey, $statusLevel1Text, $fontFile, $size = 33, $pad = 0);

        $s3 = round(180 + $percent3 * 1.8);
        textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s2, $s3, $grey, $statusLevel2Text, $fontFile, $size = 33, $pad = 0);

        $s4 = round(180 + $percent4 * 1.8);
        textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s3, $s4, $grey, $statusLevel3Text, $fontFile, $size = 33, $pad = 0);

        $s4 = round(180 + $percent4 * 1.82);
        $s5 = round(180 + 100 * 1.8);
        textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s4, $s5, $grey, $statusLevel4Text, $fontFile, $size = 33, $pad = 0);

        $textX = $this->xCenter - 100;
        if (!$complete) {
            $textX = $this->xCenter - 15;
        }
        // number to go with the needle
        imagefttext($this->image, $size = 48, $angle = 0, $x = $textX, $y = $this->yCenter - 45, $black,      $fontFile, number_format($complete, 0, '.', ','));

        // // Legend text
        imagefttext($this->image, $size = 48, $angle = 0, $x = 160, $y = 160, $black,  $fontFile, $statusLevel4Text);
        imagefttext($this->image, $size = 48, $angle = 0, $x, $y + 80, $black,  $fontFile, $statusLevel3Text);
        imagefttext($this->image, $size = 48, $angle = 0, $x, $y + 160, $black, $fontFile, $statusLevel2Text);
        imagefttext($this->image, $size = 48, $angle = 0, $x, $y + 240, $black, $fontFile, $statusLevel1Text);

        // //Legend colors
        imagefilledpolygon($this->image, [$x1 = 80, $y1 = 120,      $x2 = 120, $y2 = $y1,    $x4 = 120, $y4 = $y2 + 40, $x3 = $x1, $y3 = $y4], $no_of_points = 4, $statusLevel4ArcColor);
        imagefilledpolygon($this->image, [$x1,     $y1 = $y1 + 80,   $x2,     $y2 = $y2 + 80, $x4,     $y4 = $y4 + 80, $x3,       $y3 = $y4],   $no_of_points = 4, $statusLevel3ArcColor);
        imagefilledpolygon($this->image, [$x1,     $y1 = $y1 + 80,   $x2,     $y2 = $y2 + 80, $x4,     $y4 = $y4 + 80, $x3,       $y3 = $y4],   $no_of_points = 4, $statusLevel2ArcColor);
        imagefilledpolygon($this->image, [$x1,     $y1 = $y1 + 80,   $x2,     $y2 = $y2 + 80, $x4,     $y4 = $y4 + 80, $x3,       $y3 = $y4],   $no_of_points = 4, $statusLevel1ArcColor);

        // Set type of image and send the output
        header("Content-type: image/png");
        imagePng($this->image);
    }

    public function loyalty_status_level()
    {

        ini_set('display_errors', 1);

        $fontFile = 'arialbd.ttf';
        
        $max = LifetimeUtil::MAX_LEVEL_4;

        // Create an image with the specified dimensions
        $this->image = imagecreatetruecolor($this->xSize, $this->ySize);

        $white          = imageColorAllocate($this->image, 255, 255, 255);
        $lightgrey      = imageColorAllocate($this->image, 0xED, 0xEB, 0xEB);
        $grey           = imageColorAllocate($this->image, 127, 127, 127);
        $black          = imageColorAllocate($this->image, 0, 0, 0);

        $statusLevel1Color = LifetimeUtil::STATUS_LEVEL_1_COLOR;
        $statusLevel2Color = LifetimeUtil::STATUS_LEVEL_2_COLOR;
        $statusLevel3Color = LifetimeUtil::STATUS_LEVEL_3_COLOR;
        $statusLevel4Color = LifetimeUtil::STATUS_LEVEL_4_COLOR;

        // create the colors from hex triplets
        $statusLevel1ArcColor =      imageColorAllocate($this->image, hexdec(substr($statusLevel1Color, 1, 2)), hexdec(substr($statusLevel1Color, 3, 2)), hexdec(substr($statusLevel1Color, 5, 2)));
        $statusLevel2ArcColor =    imageColorAllocate($this->image, hexdec(substr($statusLevel2Color, 1, 2)), hexdec(substr($statusLevel2Color, 3, 2)), hexdec(substr($statusLevel2Color, 5, 2)));
        $statusLevel3ArcColor =  imageColorAllocate($this->image, hexdec(substr($statusLevel3Color, 1, 2)), hexdec(substr($statusLevel3Color, 3, 2)), hexdec(substr($statusLevel3Color, 5, 2)));
        $statusLevel4ArcColor =     imageColorAllocate($this->image, hexdec(substr($statusLevel4Color, 1, 2)), hexdec(substr($statusLevel4Color, 3, 2)), hexdec(substr($statusLevel4Color, 5, 2)));

        //background to white
        imageFilledRectangle($this->image, 0, 0, $this->xSize, $this->ySize, $white);

        $percent1 = round(LifetimeUtil::PERCENTAGE_LEVEL_1);
        $percent2 = round(LifetimeUtil::PERCENTAGE_LEVEL_2);
        $percent3 = round(LifetimeUtil::PERCENTAGE_LEVEL_3);
        $percent4 = round(LifetimeUtil::PERCENTAGE_LEVEL_4);

        $complete        = $this->request->param('complete');
        $completePercent = round($this->request->param('complete') / $max * 100);
        $completePercent = min(100, $completePercent);

        drawArc($this->image, $this->xCenter, $this->yCenter, 0,         $percent1, $statusLevel1ArcColor,         $this->gageDia / 4,  $this->gageDia / 2);
        drawArc($this->image, $this->xCenter, $this->yCenter, $percent1, $percent2, $statusLevel2ArcColor,       $this->gageDia / 4,  $this->gageDia / 2);
        drawArc($this->image, $this->xCenter, $this->yCenter, $percent2, $percent3, $statusLevel3ArcColor,     $this->gageDia / 4,  $this->gageDia / 2);
        drawArc($this->image, $this->xCenter, $this->yCenter, $percent3, $percent4, $statusLevel4ArcColor,   $this->gageDia / 4,  $this->gageDia / 2);

        drawArc($this->image, $this->xCenter, $this->yCenter, 0,         $percent1, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        drawArc($this->image, $this->xCenter, $this->yCenter, $percent1, $percent2, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        drawArc($this->image, $this->xCenter, $this->yCenter, $percent2, $percent3, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        drawArc($this->image, $this->xCenter, $this->yCenter, $percent3, $percent4, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);

        whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent1, $white);
        whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent2, $white);
        whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent3, $white);
        whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent4, $white);

        // the needle
        needleOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $completePercent, $grey, $white);

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
            $im->blurImage(3, 3);
            $im->writeImage('tempfile.png');
            $im->writeImage('tempfile2.png');
        }

        $this->image = imagecreatefrompng('tempfile.png');

        // grey outer with text labels
        $statusLevel1Text = LifetimeUtil::STATUS_LEVEL_1;
        $statusLevel2Text = LifetimeUtil::STATUS_LEVEL_2;
        $statusLevel3Text = LifetimeUtil::STATUS_LEVEL_3;
        $statusLevel4Text = LifetimeUtil::STATUS_LEVEL_4;

        $s1 = round(180 + $percent1 * 0.4);
        $s2 = round(180 + $percent2 * 0.8);
        textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s1, $s2, $grey, $statusLevel1Text, $fontFile, $size = 33, $pad = 0);

        $s3 = round(180 + $percent3 * 1.2);
        textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s2, $s3, $grey, $statusLevel2Text, $fontFile, $size = 33, $pad = 0);

        $s4 = round(180 + $percent4 * 1.1);
        textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s3, $s4, $grey, $statusLevel3Text, $fontFile, $size = 33, $pad = 0);

        $s4 = round(180 + $percent4 * 1.2);
        $s5 = round(180 + 100 * 1.8);
        textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s4, $s5, $grey, $statusLevel4Text, $fontFile, $size = 33, $pad = 0);

        $textX = $this->xCenter - 100;
        if (!$complete) {
            $textX = $this->xCenter - 15;
        }

        // // Legend text
        imagefttext($this->image, $size = 48, $angle = 0, $x = 160, $y = 160, $black,  $fontFile, $statusLevel4Text);
        imagefttext($this->image, $size = 48, $angle = 0, $x, $y + 80, $black,  $fontFile, $statusLevel3Text);
        imagefttext($this->image, $size = 48, $angle = 0, $x, $y + 160, $black, $fontFile, $statusLevel2Text);
        imagefttext($this->image, $size = 48, $angle = 0, $x, $y + 240, $black, $fontFile, $statusLevel1Text);

        // //Legend colors
        imagefilledpolygon($this->image, [$x1 = 80, $y1 = 120,      $x2 = 120, $y2 = $y1,    $x4 = 120, $y4 = $y2 + 40, $x3 = $x1, $y3 = $y4], $no_of_points = 4, $statusLevel4ArcColor);
        imagefilledpolygon($this->image, [$x1,     $y1 = $y1 + 80,   $x2,     $y2 = $y2 + 80, $x4,     $y4 = $y4 + 80, $x3,       $y3 = $y4],   $no_of_points = 4, $statusLevel3ArcColor);
        imagefilledpolygon($this->image, [$x1,     $y1 = $y1 + 80,   $x2,     $y2 = $y2 + 80, $x4,     $y4 = $y4 + 80, $x3,       $y3 = $y4],   $no_of_points = 4, $statusLevel2ArcColor);
        imagefilledpolygon($this->image, [$x1,     $y1 = $y1 + 80,   $x2,     $y2 = $y2 + 80, $x4,     $y4 = $y4 + 80, $x3,       $y3 = $y4],   $no_of_points = 4, $statusLevel1ArcColor);

        // Set type of image and send the output
        header("Content-type: image/png");
        imagePng($this->image);
    }
}
