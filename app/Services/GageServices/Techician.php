<?php

namespace App\Services\GageServices;
use App\Helper\Role;
use App\Services\GageService;
use App\Services\StatusServices\Techician as TechicianStatus;


class Techician extends GageService
{
    var $xSize = 3400;
    var $ySize = 2000;
    var $xCenter = 1800;
    var $yCenter = 1900;
    var $gageDia = 2200;

    public function current_status_level($role, $rank, $ytd, $statusChart) {

        $fileName = 'current_status.png';

        $fontFile = 'arialbd.ttf';

        $max = $statusChart['max'];

        // Create an image with the specified dimensions
        $this->image = imagecreatetruecolor($this->xSize, $this->ySize);

        $white          = imageColorAllocate($this->image, 255, 255, 255);
        $lightgrey      = imageColorAllocate($this->image, 0xED, 0xEB, 0xEB);
        $grey           = imageColorAllocate($this->image, 127, 127, 127);
        $black          = imageColorAllocate($this->image, 0, 0, 0);

        $statusLevel1Color = $statusChart['gageArray'][0][1];
        $statusLevel2Color = $statusChart['gageArray'][1][1];
        $statusLevel3Color = $statusChart['gageArray'][2][1];
        $statusLevel4Color = $statusChart['gageArray'][3][1];

        // create the colors from hex triplets
        $statusLevel1ArcColor =      imageColorAllocate($this->image, hexdec(substr($statusLevel1Color, 1, 2)), hexdec(substr($statusLevel1Color, 3, 2)), hexdec(substr($statusLevel1Color, 5, 2)));
        $statusLevel2ArcColor =    imageColorAllocate($this->image, hexdec(substr($statusLevel2Color, 1, 2)), hexdec(substr($statusLevel2Color, 3, 2)), hexdec(substr($statusLevel2Color, 5, 2)));
        $statusLevel3ArcColor =  imageColorAllocate($this->image, hexdec(substr($statusLevel3Color, 1, 2)), hexdec(substr($statusLevel3Color, 3, 2)), hexdec(substr($statusLevel3Color, 5, 2)));
        $statusLevel4ArcColor =     imageColorAllocate($this->image, hexdec(substr($statusLevel4Color, 1, 2)), hexdec(substr($statusLevel4Color, 3, 2)), hexdec(substr($statusLevel4Color, 5, 2)));

        //background to white
        imageFilledRectangle($this->image, 0, 0, $this->xSize, $this->ySize, $white);

        $percent1 = round($statusChart['gageArray'][0][0]);
        $percent2 = round($statusChart['gageArray'][1][0]);
        $percent3 = round($statusChart['gageArray'][2][0]);
        $percent4 = round($statusChart['gageArray'][3][0]);

        $complete        = floatval($ytd);
        $completePercent = $this->calculateCompletePercent($role, $rank);

        $this->drawArc($this->image, $this->xCenter, $this->yCenter, 0,         $percent1, $lightgrey,         $this->gageDia / 4,  $this->gageDia / 2);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent1, $percent2, $statusLevel1ArcColor,       $this->gageDia / 4,  $this->gageDia / 2);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent2, $percent3, $statusLevel2ArcColor,     $this->gageDia / 4,  $this->gageDia / 2);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent3, $percent4, $statusLevel3ArcColor,   $this->gageDia / 4,  $this->gageDia / 2);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent4, 100,       $statusLevel4ArcColor,      $this->gageDia / 4,  $this->gageDia / 2);

        $this->drawArc($this->image, $this->xCenter, $this->yCenter, 0,         $percent1, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent1, $percent2, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent2, $percent3, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent3, $percent4, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent4, 100,       $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);

        $this->whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent1, $white);
        $this->whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent2, $white);
        $this->whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent3, $white);
        $this->whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent4, $white);
        $this->whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, 100,       $white);

        // the needle
        $this->needleOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $completePercent, $grey, $white);

        // // Jo's grey arrow for first sector below consul   //start at 5% and finish 7% before consul, with 2% for arrowhead
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, 3, $percent1 - 4, $grey,         $this->gageDia * .55,  $this->gageDia * .56);

        // // arrowhead
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

        $fo = fopen($fileName, 'w');
        imagePng($this->image, $fileName);
        //imageDestroy($this->image);
        //fclose($fo);

        // save image, open in Imagick, blur the image - to removed the jagged edges on the diagonal lines
        if (class_exists('Imagick')) {
            $file = fopen($fileName, 'r');
            $im = new \Imagick();
            $im->readImageFile($file);
            $im->blurImage(3, 3);
            $im->writeImage($fileName);
        }

        $this->image = imagecreatefrompng($fileName);

        $s1 = round(180 + $percent1 * 1.788);
        $s2 = round(180 + $percent2 * 1.8);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s1, $s2, $grey, TechicianStatus::STATUS_LEVEL_1, $fontFile, $size = 42, $pad = 0);

        $s3 = round(180 + $percent3 * 1.8);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s2, $s3, $grey, TechicianStatus::STATUS_LEVEL_2, $fontFile, $size = 42, $pad = 0);

        $s4 = round(180 + $percent4 * 1.8);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s3, $s4, $grey, TechicianStatus::STATUS_LEVEL_3, $fontFile, $size = 42, $pad = 0);

        $s4 = round(180 + $percent4 * 1.82);
        $s5 = round(180 + 100 * 1.8);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s4, $s5, $grey, TechicianStatus::STATUS_LEVEL_4, $fontFile, $size = 42, $pad = 0);

        $textX = $this->xCenter - 100;
        if (!$complete) {
            $textX = $this->xCenter - 15;
        }
        // number to go with the needle
        imagefttext($this->image, $size = 48, $angle = 0, $x = $textX, $y = $this->yCenter - 45, $black,      $fontFile, number_format($complete, 0, '.', ','));

        // // Legend text
        imagefttext($this->image, $size = 48, $angle = 0, $x = 160, $y = 160, $black,  $fontFile, TechicianStatus::LEGEND_LEVEL_4);
        imagefttext($this->image, $size = 48, $angle = 0, $x, $y + 80, $black,  $fontFile, TechicianStatus::LEGEND_LEVEL_3);
        imagefttext($this->image, $size = 48, $angle = 0, $x, $y + 160, $black, $fontFile, TechicianStatus::LEGEND_LEVEL_2);
        imagefttext($this->image, $size = 48, $angle = 0, $x, $y + 240, $black, $fontFile, TechicianStatus::LEGEND_LEVEL_1);

        // //Legend colors
        imagefilledpolygon($this->image, [$x1 = 80, $y1 = 120,      $x2 = 120, $y2 = $y1,    $x4 = 120, $y4 = $y2 + 40, $x3 = $x1, $y3 = $y4], $no_of_points = 4, $statusLevel4ArcColor);
        imagefilledpolygon($this->image, [$x1,     $y1 = $y1 + 80,   $x2,     $y2 = $y2 + 80, $x4,     $y4 = $y4 + 80, $x3,       $y3 = $y4],   $no_of_points = 4, $statusLevel3ArcColor);
        imagefilledpolygon($this->image, [$x1,     $y1 = $y1 + 80,   $x2,     $y2 = $y2 + 80, $x4,     $y4 = $y4 + 80, $x3,       $y3 = $y4],   $no_of_points = 4, $statusLevel2ArcColor);
        imagefilledpolygon($this->image, [$x1,     $y1 = $y1 + 80,   $x2,     $y2 = $y2 + 80, $x4,     $y4 = $y4 + 80, $x3,       $y3 = $y4],   $no_of_points = 4, $statusLevel1ArcColor);

        // Set type of image and send the output
        //header("Content-type: image/png");
        //imagePng($this->image);
        imagePng($this->image, $fileName);
        //imageDestroy($this->image);
        fclose($fo);
    }

    private function calculateCompletePercent($role, $rank) {
        $rankInt = intval($rank);
        $percent = 0;
        switch($role) {
            case Role::ADVANCED_TECHNICIAN:
                if($rankInt === 0) {
                    $percent = 0;
                }
                else if($rankInt <= 20 && $rankInt > 0){
                    $percent = 50;
                }else{
                    $percent = 30;
                }
                break;
            case Role::MASTER_TECHNICIAN:
                if($rankInt === 0) {
                    $percent = 0;
                } else if($rankInt <= 10 && $rankInt > 0){
                    $percent = 90;
                }else if($rankInt <= 30){
                    $percent = 70;
                }else{
                    $percent = 30;
                }
                break;
            default:
                break;
        }
        return $percent;
    }
}