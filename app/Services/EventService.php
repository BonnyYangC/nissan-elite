<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Region;

class EventService extends BaseService {

    /**
     * @param array $input
     */
    public function updateEvent(array $input) {
        $incentives = $this->serviceResolver->incentivesService()->load();
        if(isset($input['incentive_name'])) {
            $input['incentive_name'] = $incentives->filter(function ($f) use ($input) {
                return $f->id === intval($input['incentive_id']);
            })->first()->title;
        }
        $this->update($input);
    }

    /**
     * @return
     */
    public function load() {
        return Event::select('id',
            'title',
            'start',
            'end')->get();
    }

    /**
     * @param null $region
     * @return mixed
     */
    public static function getEventsByRegion($region = null) {
        $region = self::getRegion($region);
        return Event::whereIn('region', $region)
            ->orderBy('id', 'DESC')
            ->paginate();
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

    /**
     * @param $newData
     * @return \App\core\Model|bool|string
     */
    public function update($newData) {
        if(!empty($newData['id'])){
            $event = Event::find($newData['id']);
        }else{
            $event = new Event();
        }
        $event->title = $newData['title'];
        $event->start = $newData['start'];
        $event->end = $newData['end'];
        $event->region = $newData['region'];
        $event->description = $newData['description'];
        $event->incentive_id = intval($newData['incentive_id']);
        $event->incentive_name = isset($newData['incentive_name']) ? $newData['incentive_name'] : null;

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
}
