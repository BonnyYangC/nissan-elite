<?php

namespace App\Services;

use App\Models\Guild\Events;
use App\Models\Guild\Members;

class GuildService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * @return
     */
    public function getEvents() {
        return Events::get()->reduce(function($r, $m) {
            switch($m->type) {
                case 1:
                    $r['PLATINUM'][] = $m;
                    break;
                case 2:
                    $r['GOLD'][] = $m;
                    break;
                case 3:
                    $r['LIFETIME'][] = $m;
                    break;
            }
            return $r;
        }, [
            'PLATINUM' => [],
            'GOLD' => [],
            'LIFETIME' => []
        ]);
    }

    /**
     * @return
     */
    public function getMembers() {
        return Members::get()->reduce(function($r, $m) {
            switch($m->type) {
                case 1:
                    $r['PLATINUM'][] = $m;
                    break;
                case 2:
                    $r['GOLD'][] = $m;
                    break;
                case 3:
                    $r['LIFETIME'][] = $m;
                    break;
            }
            return $r;
        }, [
            'PLATINUM' => [],
            'GOLD' => [],
            'LIFETIME' => []
        ]);
    }
}
