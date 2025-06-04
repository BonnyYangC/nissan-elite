<?php

namespace App\Services\GageServices;

use App\Services\GageService;
use App\Services\StatusServices\Loyalty as LoyaltyStatus;


class Loyalty extends GageService
{
    public function loyalty_status_level($complete) {

        $fileName = 'loyalty_status.png';
        ini_set('display_errors', 1);

        $fontFile = 'arialbd.ttf';

        $max = LoyaltyStatus::MAX_LEVEL_4;

        // Create an image with the specified dimensions
        $this->image = imagecreatetruecolor($this->xSize, $this->ySize);

        $white          = imageColorAllocate($this->image, 255, 255, 255);
        $lightgrey      = imageColorAllocate($this->image, 0xED, 0xEB, 0xEB);
        $grey           = imageColorAllocate($this->image, 127, 127, 127);
        $black          = imageColorAllocate($this->image, 0, 0, 0);

        $statusLevel1Color = LoyaltyStatus::STATUS_LEVEL_1_COLOR;
        $statusLevel2Color = LoyaltyStatus::STATUS_LEVEL_2_COLOR;
        $statusLevel3Color = LoyaltyStatus::STATUS_LEVEL_3_COLOR;
        $statusLevel4Color = LoyaltyStatus::STATUS_LEVEL_4_COLOR;

        // create the colors from hex triplets
        $statusLevel1ArcColor =      imageColorAllocate($this->image, hexdec(substr($statusLevel1Color, 1, 2)), hexdec(substr($statusLevel1Color, 3, 2)), hexdec(substr($statusLevel1Color, 5, 2)));
        $statusLevel2ArcColor =    imageColorAllocate($this->image, hexdec(substr($statusLevel2Color, 1, 2)), hexdec(substr($statusLevel2Color, 3, 2)), hexdec(substr($statusLevel2Color, 5, 2)));
        $statusLevel3ArcColor =  imageColorAllocate($this->image, hexdec(substr($statusLevel3Color, 1, 2)), hexdec(substr($statusLevel3Color, 3, 2)), hexdec(substr($statusLevel3Color, 5, 2)));
        $statusLevel4ArcColor =     imageColorAllocate($this->image, hexdec(substr($statusLevel4Color, 1, 2)), hexdec(substr($statusLevel4Color, 3, 2)), hexdec(substr($statusLevel4Color, 5, 2)));

        //background to white
        imageFilledRectangle($this->image, 0, 0, $this->xSize, $this->ySize, $white);

        $percent1 = round(LoyaltyStatus::PERCENTAGE_LEVEL_1);
        $percent2 = round(LoyaltyStatus::PERCENTAGE_LEVEL_2);
        $percent3 = round(LoyaltyStatus::PERCENTAGE_LEVEL_3);
        $percent4 = round(LoyaltyStatus::PERCENTAGE_LEVEL_4);

        $complete        = floatval($complete);
        $completePercent = round(floatval($complete) / $max * 100);
        $completePercent = min(100, $completePercent);

        $this->drawArc($this->image, $this->xCenter, $this->yCenter, 0,         $percent1, $statusLevel1ArcColor,         $this->gageDia / 4,  $this->gageDia / 2);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent1, $percent2, $statusLevel2ArcColor,       $this->gageDia / 4,  $this->gageDia / 2);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent2, $percent3, $statusLevel3ArcColor,     $this->gageDia / 4,  $this->gageDia / 2);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent3, $percent4, $statusLevel4ArcColor,   $this->gageDia / 4,  $this->gageDia / 2);

        $this->drawArc($this->image, $this->xCenter, $this->yCenter, 0,         $percent1, theme_config('status_level_wheel_surround_color'),         $this->gageDia * .51,  $this->gageDia * .6);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent1, $percent2, theme_config('status_level_wheel_surround_color'),         $this->gageDia * .51,  $this->gageDia * .6);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent2, $percent3, theme_config('status_level_wheel_surround_color'),         $this->gageDia * .51,  $this->gageDia * .6);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent3, $percent4, theme_config('status_level_wheel_surround_color'),         $this->gageDia * .51,  $this->gageDia * .6);

        $this->whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent1, $white);
        $this->whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent2, $white);
        $this->whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent3, $white);
        $this->whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent4, $white);

        // the needle
        $this->needleOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $completePercent, $grey, $white);

        putenv('GDFONTPATH=' . realpath('.'));

        $fo = fopen($fileName, 'w');
        imagePng($this->image, $fileName);
        imageDestroy($this->image);
        //fclose($fo);

        // save image, open in Imagick, blur the image - to removed the jagged edges on the diagonal lines
        if (class_exists('Imagick')) {
            $file = fopen($fileName, 'r');
            $im = new \Imagick();
            $im->readImageFile($file);
            $im->blurImage(3, 3);
            $im->writeImage($fileName);
            //$im->writeImage('tempfile2.png');
        }

        $this->image = imagecreatefrompng($fileName);

        // grey outer with text labels
        $statusLevel1Text = LoyaltyStatus::STATUS_LEVEL_1;
        $statusLevel2Text = LoyaltyStatus::STATUS_LEVEL_2;
        $statusLevel3Text = LoyaltyStatus::STATUS_LEVEL_3;
        $statusLevel4Text = LoyaltyStatus::STATUS_LEVEL_4;

        $s1 = round(180 + $percent1 * 0.4);
        $s2 = round(180 + $percent2 * 0.8);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s1, $s2, theme_config('status_level_wheel_text_color'), $statusLevel1Text, $fontFile, $size = 33, $pad = 0);

        $s3 = round(180 + $percent3 * 1.2);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s2, $s3, theme_config('status_level_wheel_text_color'), $statusLevel2Text, $fontFile, $size = 33, $pad = 0);

        $s4 = round(180 + $percent4 * 1.1);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s3, $s4, theme_config('status_level_wheel_text_color'), $statusLevel3Text, $fontFile, $size = 33, $pad = 0);

        $s4 = round(180 + $percent4 * 1.2);
        $s5 = round(180 + 100 * 1.8);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s4, $s5, theme_config('status_level_wheel_text_color'), $statusLevel4Text, $fontFile, $size = 33, $pad = 0);

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
        imagePng($this->image, $fileName);
        fclose($fo);
    }
}