<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Dealer
 * @package App\Models
 * @property $parent_id
 */
class Dealer extends Model
{
    use HasFactory;

    public function regions() {
        return $this->hasOne(DealerRegion::class, 'code', 'code')->where('year', config('elite.YEAR'));
    }
}
