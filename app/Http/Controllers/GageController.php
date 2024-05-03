<?php
namespace App\Http\Controllers;

use App\helper\Loyalty;
use App\Services\ServiceResolver;
use Illuminate\Http\Request;

class GageController extends Controller {

    /** @var ServiceResolver */
    protected $serviceResolver;

    var $xSize = 2800;
    var $ySize = 1200;
    var $xCenter = 1600;
    var $yCenter = 1100;
    var $gageThick = 80;
    var $gageDia = 1800;
    var $image;

    /**
     * GageController constructor.
     * @param ServiceResolver $serviceResolver
     * @param Request $request
     */
    public function __construct(ServiceResolver $serviceResolver, Request $request) {
        parent::__construct($request);
        $this->serviceResolver = $serviceResolver;
    }

    /**
     * @param Request $request
     * @throws \ImagickException
     */
    public function current_status_level(Request $request) {

        $fileName = 'current_status.png';
        //ini_set('display_errors', 1);

        //$role = RoleFactory::GetRole($pos = $this->request->param('position'), new User($this->request->param('id')));

        //$ytd = env('YEAR');
        //$dataForView = $role->getDashboardViewData($this->dataForView, $ytd);
        $selectedPosition = $this->dataForView['selectedPosition']->get('code');
        $ytd = $this->serviceResolver->resultService()->getYearToDateData($selectedPosition);
        $ytd = $ytd ? $ytd : '';
        //var_dump($ytd);
        $dataForView['statusChart'] = array_merge([
            'ytd' => $ytd
        ], $this->serviceResolver->statusService()->buildStatusData($ytd));

        $fontpath = realpath('.'); //replace . with a different directory if needed
        putenv('GDFONTPATH='.$fontpath);
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

        $complete        = floatval($ytd);
        $completePercent = round($complete / $max * 100);
        $completePercent = min(100, $completePercent);

        $this->drawArc($this->image, $this->xCenter, $this->yCenter, 0,         $percent1, $lightgrey,         $this->gageDia / 4,  $this->gageDia / 2);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent1, $percent2, $statusLevel1ArcColor,       $this->gageDia / 4,  $this->gageDia / 2);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent2, $percent3, $statusLevel2ArcColor,     $this->gageDia / 4,  $this->gageDia / 2);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent3, $percent4, $statusLevel3ArcColor,   $this->gageDia / 4,  $this->gageDia / 2);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent4, 101,       $statusLevel4ArcColor,      $this->gageDia / 4,  $this->gageDia / 2);

        $this->drawArc($this->image, $this->xCenter, $this->yCenter, 0,         $percent1, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent1, $percent2, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent2, $percent3, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent3, $percent4, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent4, 101,       $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);

        $this->whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent1, $white);
        $this->whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent2, $white);
        $this->whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent3, $white);
        $this->whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $percent4, $white);
        $this->whiteDividerInArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, 101,       $white);

        // the needle
        $this->needleOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia, $completePercent, $grey, $white);

        // // Jo's grey arrow for first sector below consul   //start at 5% and finish 7% before consul, with 2% for arrowhead
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, 3, $percent1 - 4, $grey,         $this->gageDia * .55,  $this->gageDia * .56);

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
            //$im->writeImage('tempfile2.png');
        }

        $this->image = imagecreatefrompng($fileName);

        // grey outer with text labels
        $statusLevel1Text = $dataForView['statusChart']['gageArray'][0][2];
        $statusLevel2Text = $dataForView['statusChart']['gageArray'][1][2];
        $statusLevel3Text = $dataForView['statusChart']['gageArray'][2][2];
        $statusLevel4Text = $dataForView['statusChart']['gageArray'][3][2];

        $s1 = round(180 + $percent1 * 1.788);
        $s2 = round(180 + $percent2 * 1.8);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s1, $s2, $grey, $statusLevel1Text, $fontFile, $size = 33, $pad = 0);

        $s3 = round(180 + $percent3 * 1.8);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s2, $s3, $grey, $statusLevel2Text, $fontFile, $size = 33, $pad = 0);

        $s4 = round(180 + $percent4 * 1.8);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s3, $s4, $grey, $statusLevel3Text, $fontFile, $size = 33, $pad = 0);

        $s4 = round(180 + $percent4 * 1.82);
        $s5 = round(180 + 100 * 1.8);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s4, $s5, $grey, $statusLevel4Text, $fontFile, $size = 33, $pad = 0);

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
        //imagePng($this->image);
        imagePng($this->image, $fileName);
        //imageDestroy($this->image);
        fclose($fo);
    }

    /**
     * @throws \ImagickException
     */
    public function loyalty_status_level() {

        $fileName = 'loyalty_status.png';
        ini_set('display_errors', 1);

        $fontFile = 'arialbd.ttf';

        $max = Loyalty::MAX_LEVEL_4;

        // Create an image with the specified dimensions
        $this->image = imagecreatetruecolor($this->xSize, $this->ySize);

        $white          = imageColorAllocate($this->image, 255, 255, 255);
        $lightgrey      = imageColorAllocate($this->image, 0xED, 0xEB, 0xEB);
        $grey           = imageColorAllocate($this->image, 127, 127, 127);
        $black          = imageColorAllocate($this->image, 0, 0, 0);

        $statusLevel1Color = Loyalty::STATUS_LEVEL_1_COLOR;
        $statusLevel2Color = Loyalty::STATUS_LEVEL_2_COLOR;
        $statusLevel3Color = Loyalty::STATUS_LEVEL_3_COLOR;
        $statusLevel4Color = Loyalty::STATUS_LEVEL_4_COLOR;

        // create the colors from hex triplets
        $statusLevel1ArcColor =      imageColorAllocate($this->image, hexdec(substr($statusLevel1Color, 1, 2)), hexdec(substr($statusLevel1Color, 3, 2)), hexdec(substr($statusLevel1Color, 5, 2)));
        $statusLevel2ArcColor =    imageColorAllocate($this->image, hexdec(substr($statusLevel2Color, 1, 2)), hexdec(substr($statusLevel2Color, 3, 2)), hexdec(substr($statusLevel2Color, 5, 2)));
        $statusLevel3ArcColor =  imageColorAllocate($this->image, hexdec(substr($statusLevel3Color, 1, 2)), hexdec(substr($statusLevel3Color, 3, 2)), hexdec(substr($statusLevel3Color, 5, 2)));
        $statusLevel4ArcColor =     imageColorAllocate($this->image, hexdec(substr($statusLevel4Color, 1, 2)), hexdec(substr($statusLevel4Color, 3, 2)), hexdec(substr($statusLevel4Color, 5, 2)));

        //background to white
        imageFilledRectangle($this->image, 0, 0, $this->xSize, $this->ySize, $white);

        $percent1 = round(Loyalty::PERCENTAGE_LEVEL_1);
        $percent2 = round(Loyalty::PERCENTAGE_LEVEL_2);
        $percent3 = round(Loyalty::PERCENTAGE_LEVEL_3);
        $percent4 = round(Loyalty::PERCENTAGE_LEVEL_4);

        $complete        = floatval('281620'); // $this->request->param('complete');
        $completePercent = round(floatval('281620') / $max * 100); // round($this->request->param('complete') / $max * 100);
        $completePercent = min(100, $completePercent);

        $this->drawArc($this->image, $this->xCenter, $this->yCenter, 0,         $percent1, $statusLevel1ArcColor,         $this->gageDia / 4,  $this->gageDia / 2);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent1, $percent2, $statusLevel2ArcColor,       $this->gageDia / 4,  $this->gageDia / 2);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent2, $percent3, $statusLevel3ArcColor,     $this->gageDia / 4,  $this->gageDia / 2);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent3, $percent4, $statusLevel4ArcColor,   $this->gageDia / 4,  $this->gageDia / 2);

        $this->drawArc($this->image, $this->xCenter, $this->yCenter, 0,         $percent1, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent1, $percent2, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent2, $percent3, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);
        $this->drawArc($this->image, $this->xCenter, $this->yCenter, $percent3, $percent4, $lightgrey,         $this->gageDia * .51,  $this->gageDia * .6);

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
        $statusLevel1Text = Loyalty::STATUS_LEVEL_1;
        $statusLevel2Text = Loyalty::STATUS_LEVEL_2;
        $statusLevel3Text = Loyalty::STATUS_LEVEL_3;
        $statusLevel4Text = Loyalty::STATUS_LEVEL_4;

        $s1 = round(180 + $percent1 * 0.4);
        $s2 = round(180 + $percent2 * 0.8);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s1, $s2, $grey, $statusLevel1Text, $fontFile, $size = 33, $pad = 0);

        $s3 = round(180 + $percent3 * 1.2);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s2, $s3, $grey, $statusLevel2Text, $fontFile, $size = 33, $pad = 0);

        $s4 = round(180 + $percent4 * 1.1);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s3, $s4, $grey, $statusLevel3Text, $fontFile, $size = 33, $pad = 0);

        $s4 = round(180 + $percent4 * 1.2);
        $s5 = round(180 + 100 * 1.8);
        $this->textOnArc($this->image, $this->xCenter, $this->yCenter, $this->gageDia / 1.85, $s4, $s5, $grey, $statusLevel4Text, $fontFile, $size = 33, $pad = 0);

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
        fclose($fo);
    }

    private function drawArc($image, $xCenter, $yCenter, $startPercent, $endPercent, $color, $innerRad, $outerRad)
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

    private function whiteDividerInArc($image, $xCenter, $yCenter, $gageDia, $percent, $color)
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

    private function textOnArc($image, $xCenter, $yCenter, $radian, $startAngle, $endAngle, $textColor, $text, $fontFile, $fontSize, $pad = 0)
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

    private function needleOnArc($image, $xCenter, $yCenter, $gageDia, $percent, $color, $colorSpindle)
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

    private function textWidth($text, $fontFile, $fontSize)
    {

        $bbox = imagettfbbox($fontSize, 0, $fontFile, $text);

        $w = abs($bbox[4] - $bbox[0]);  //upper right corner, X position - lower left corner, X position

        return $w;
    }
}
