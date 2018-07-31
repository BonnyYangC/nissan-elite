<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 26/7/18
 * Time: 2:54 PM
 */

namespace App\models\nissan;

use App\models\BaseModel;

class Events extends BaseModel
{
    const TABLE_NAME = 'nissan_events';
    protected $tableName = 'nissan_events';

    /**
     * Load Nissan events
     * @param string $orderBy
     * @return array|bool
     */
    public static function Load($orderBy = 'datestamp'){
        $database = self::DB();
        return $database->select(
            self::TABLE_NAME,
            '*',
            [
                'ORDER'=>[$orderBy]
            ]
        );
    }

    /**
     * Load Nissan events
     * @param string $orderBy
     * @return array|bool
     */
    public static function LoadForCalendarEvents($orderBy = 'datestamp'){
        $database = self::DB();
        $events = $database->select(
            self::TABLE_NAME,
            ['title','datestamp(start)'],
            [
                'ORDER'=>[$orderBy]
            ]
        );
        return $events;
    }
}