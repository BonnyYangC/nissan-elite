<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acl extends Model
{
    use HasFactory;

    /**
     * get acl by role code
     *
     * @param [string] $code
     * @return mixed
     */
    public static function getAllByPosition($code)
    {
        return self::where('position', $code)
            ->pluck('page')
            ->toArray();
    }
}
