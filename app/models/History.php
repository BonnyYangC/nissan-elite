<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Result
 * @var string $period
 * @package App\Models
 */
class History extends Model {
    use HasFactory;

    protected $table = 'nissan_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'period', 'member_id', // should change to 'employee_code',
        'amount'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'period' => 'integer',
        'amount' => 'float'
    ];

    /**
     * @param string $employeeCode
     * @return mixed
     */
    public static function getLoyaltyToTheBrandData(string $employeeCode) {
        return History::where('period', '<', '2019-01-01')
            ->where('member_id', $employeeCode)
            ->sum('amount');
    }

    /**
     * @param string $employeeCode
     * @return mixed
     */
    public static function getTotalHistoricalData(string $employeeCode) {
        return History::where('member_id', $employeeCode)
            ->sum('amount');
    }

    /**
     * @param string $employeeCode
     * @return mixed
     */
    public static function getAllHistoricalData(string $employeeCode) {
        return History::select('period', 'amount')
        ->where('member_id', $employeeCode)->get();
    }
}
