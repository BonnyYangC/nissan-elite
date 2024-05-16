<?php

namespace App\Services;

use App\Models\{Event, Incentive, Region};

class EventService {

    public function updateEvent(array $newData) {
        if(!empty($newData['id'])){
            $event = Event::find($newData['id']);
        }else{
            $event = Event::factory()->make();
        }
        $event->title = $newData['title'];
        $event->start = $newData['start'];
        $event->end = $newData['end'];
        $event->region = $newData['region'];
        $event->description = $newData['description'];
        $event->incentive = intval($newData['incentive_id']) ?: null;

        return $event->save();
    }

    /**
     * @param Event $event
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Event $event) {
        return $event->delete();
    }

    /**
     * @return
     */
    public function load() {
        return Event::loadAll()->get();
    }

    /**
     * @return
     */
    public function loadIncentives() {
        return Incentive::loadall()->get();
    }

    /**
     * @param null $region
     * @return mixed
     */
    public static function getEventsByRegion($region = null) {
        $region = self::getRegion($region);
        return Event::byRegion($region)->paginate();
    }

    /**
     * @param null $region
     * @return array|null
     */
    private static function getRegion($region = null) {
        if (!$region) {
            $region = [Region::REGION_ALL, Region::REGION_EASTERN, Region::REGION_NORTHERN, Region::REGION_WESTERN, Region::REGION_SOUTHERN];
        } else {
            $region = array_unique(array_merge($region, [Region::REGION_ALL]));
        }
        return $region;
    }
}
