<?php
namespace App\Services;

class GageService {

    var $xSize = 2800;
    var $ySize = 1200;
    var $xCenter = 1600;
    var $yCenter = 1100;
    var $gageThick = 80;
    var $gageDia = 1800;
    var $image;

    protected function drawArc($image, $xCenter, $yCenter, $startPercent, $endPercent, $color, $innerRad, $outerRad)
    {
        $startAngle = round(180 - $startPercent * 1.8);
        $endAngle   = round(180 - $endPercent * 1.8);

        $x1 = $xCenter + cos(deg2rad($startAngle)) * $outerRad;
        $y1 = $yCenter - sin(deg2rad($startAngle)) * $outerRad;

        $x2 = $xCenter + cos(deg2rad($startAngle)) * $innerRad;
        $y2 = $yCenter - sin(deg2rad($startAngle)) * $innerRad;

        $polys = [$x1, $y1];

        // back array is the inner arc, and reversed below
        $back = [$y2, $x2]; // reverse order, because we are going to reverse this

        for ($i = 1; $i <= ($startAngle - $endAngle); $i++) {
            $angle = $startAngle - $i;

            $x3 = $xCenter + cos(deg2rad($angle)) * $outerRad;
            $y3 = $yCenter - sin(deg2rad($angle)) * $outerRad;

            $polys[] = $x3;
            $polys[] = $y3;


            $x4 = $xCenter + cos(deg2rad($angle)) * $innerRad;
            $y4 = $yCenter - sin(deg2rad($angle)) * $innerRad;

            $back[] = $y4;
            $back[] = $x4;
        }

        $polys = array_merge($polys, array_reverse($back));

        imagefilledpolygon($image, $polys, count($polys) / 2, $color);
    }

    protected function whiteDividerInArc($image, $xCenter, $yCenter, $gageDia, $percent, $color)
    {
        $angle = round(180 + ($percent * 1.8));
        $lineThickness = 10;
        $lineLength = $gageDia / 1.666;


        $x1 = $xCenter + cos(deg2rad($angle - 90)) * $lineThickness / 2;
        $y1 = $yCenter + sin(deg2rad($angle - 90)) * $lineThickness / 2;

        $x2 = $xCenter + cos(deg2rad($angle + 90)) * $lineThickness / 2;
        $y2 = $yCenter + sin(deg2rad($angle + 90)) * $lineThickness / 2;

        $x3 = $x1 + cos(deg2rad($angle)) * $lineLength;
        $y3 = $y1 + sin(deg2rad($angle)) * $lineLength;

        $x4 = $x2 + cos(deg2rad($angle)) * $lineLength;
        $y4 = $y2 + sin(deg2rad($angle)) * $lineLength;

        imagefilledpolygon($image, [$x2, $y2, $x1, $y1, $x3, $y3, $x4, $y4], $no_of_points = 4, $color);
    }

    protected function textOnArc($image, $xCenter, $yCenter, $radian, $startAngle, $endAngle, $textColor, $text, $fontFile, $fontSize, $pad = 0)
    {

        $textLength = strlen($text);  //length of text

        $textCentreAngle = ($endAngle + $startAngle) / 2;  // centre angle of text

        $totalTextWidth = $this->textWidth($text, $fontFile, $fontSize) - ($textLength - 1) * $pad;

        $textAngle = rad2deg($totalTextWidth / $radian);  //Converts the radian number to the equivalent number in degrees

        $startAngle = $textCentreAngle - $textAngle / 2;

        $endAngle = $textCentreAngle + $textAngle / 2;

        for ($i = 0, $theta = deg2rad($startAngle); $i < $textLength; $i++) {

            $character = $text[$i];

            $tx = $xCenter + $radian * cos($theta);

            $ty = $yCenter + $radian * sin($theta);

            $dtheta = ($this->textWidth($character, $fontFile, $fontSize)) / $radian;

            $angle = rad2deg(M_PI * 3 / 2 - ($dtheta / 2 + $theta));

            imagettftext($image, $fontSize, $angle, $tx, $ty, $textColor, $fontFile, $character);

            $theta += $dtheta;
        }
    }

    protected function needleOnArc($image, $xCenter, $yCenter, $gageDia, $percent, $color, $colorSpindle)
    {
        $angle = 180 + ($percent * 1.8);
        $x1 = $xCenter + cos(deg2rad($angle)) * $gageDia / 2 * 0.55;
        $y1 = $yCenter + sin(deg2rad($angle)) * $gageDia / 2 * 0.55;

        $needleThickness = 80;

        $x2 = $xCenter + cos(deg2rad($angle - 90)) * $needleThickness / 2;
        $y2 = $yCenter + sin(deg2rad($angle - 90)) * $needleThickness / 2;

        $x3 = $xCenter + cos(deg2rad($angle + 90)) * $needleThickness / 2;
        $y3 = $yCenter + sin(deg2rad($angle + 90)) * $needleThickness / 2;

        imagefilledpolygon($image, [$x1, $y1, $x2, $y2, $x3, $y3], $no_of_points = 3, $color);

        imagefilledarc($image, $xCenter, $yCenter, $needleThickness,   $needleThickness,   0, 360, $color, IMG_ARC_EDGED);
        imagefilledarc($image, $xCenter, $yCenter, $needleThickness / 2.5, $needleThickness / 2.5, 0, 360, $colorSpindle, IMG_ARC_EDGED);
    }

    protected function textWidth($text, $fontFile, $fontSize)
    {

        $bbox = imagettfbbox($fontSize, 0, $fontFile, $text);

        $w = abs($bbox[4] - $bbox[0]);  //upper right corner, X position - lower left corner, X position

        return $w;
    }
}
