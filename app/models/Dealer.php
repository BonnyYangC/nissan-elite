<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Dealer
 * @package App\Models
 * @property $parent_id
 * @property string code
 */
class Dealer extends Model
{
    use HasFactory;

    public function regions() {
        return $this->hasOne(DealerRegion::class, 'code', 'code')->where('year', config('view.theme'));
    }

    public function getDp(){
        return User::where('dealer_code',$this->code)
            ->where('position_code','D')->first();
    }
}
