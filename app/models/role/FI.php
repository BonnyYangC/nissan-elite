<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 25/7/18
 * Time: 5:44 PM
 */

namespace App\models\role;


class FI
{
    public static $StatusLevelThresholds = [

        'PREMIER'    =>[
            'val'=>50000,
            'color'=>'#B47C37'
        ],
        'AMBASSADOR'    =>[
            'val'=>30000,
            'color'=>'#546E22'
        ],
        'DIPLOMAT'    =>[
            'val'=>25000,
            'color'=>'#BC2628'
        ],
        'CONSUL'    =>[
            'val'=>11000,
            'color'=>'#525357'
        ],
        'DEFAULT'   =>[
            'val'=>0,
            'color'=>'#000000'
        ],
    ];
}