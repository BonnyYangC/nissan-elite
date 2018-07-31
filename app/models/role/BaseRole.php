<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 31/7/18
 * Time: 3:31 PM
 */

namespace App\models\role;

use App\models\User;
class BaseRole
{
    protected $user;

    /**
     * Metrics data
     * @var array
     */
    public $JS_newVehicleSales = [];
    public $JS_reCommendation  = [];
    public $JS_followUpCredits = [];
    public $JS_training        = [];
    public $salesResult                 = [];
    public $salesRecommendationResult   = [];
    public $followUpCredits             = [];

    /**
     * Dashboard data
     * @var array
     */
    public $credits = [];
    public $JS_credits = [];
    public $lifeTime = null;
    public $excellence = null;
    public $newVehicleSales = [
        'label'=>'New Vehicle Sales',
        'backgroundColor' => '#333333',
        'data'=>[]
    ];
    public $salesRecommendationSaturation   = [
        'label'=>'Sales Recommendation R6M',
        'backgroundColor' => '#333333',
        'data'=>[]
    ];
    public $followUpSaturation             = [
        'label'=>'Follow Up R6M',
        'backgroundColor' => '#555555',
        'data'=>[]
    ];
    public $training = [
        'label'=>'Training',
        'backgroundColor' => '#c40030',
        'data'=>[]
    ];
    public $followUpPercentage= [
        'label'=>'Follow Up %',
        'backgroundColor' => '#555555',
        'data'=>[]
    ];
    public $matchedOW = [
        'label'=>'Matched OW',
        'backgroundColor' => '#000000',
        'data'=>[]
    ];
    public $DlrRec = [
        'label'=>'Dlr Rec',
        'backgroundColor' => '#999999',
        'data'=>[]
    ];
    public $middleMonth = [
        'label'=>'Mid Mth',
        'backgroundColor' => '#d2d2d2',
        'data'=>[]
    ];

    public function __construct(User $user = null)
    {
        $this->user = $user;
    }
}