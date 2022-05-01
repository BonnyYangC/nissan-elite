<?php

namespace App\Services;

use App\Models\Incentive;
use Carbon\Carbon;

class IncentiveService {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }

    /**
     * @return mixed
     */
    public function load() {
        return Incentive::get();
    }

    /**
     * @param array $region
     * @return array
     */
    public function current(array $region = []): array {
        return Incentive::getCurrent($region)->all();
    }

    /**
     * @param array $region
     * @return array
     */
    public function justFinished(array $region = []): array {
        return Incentive::getFinished($region)->each(function ($item) {
            $item->start = Carbon::createFromFormat('Y-m-d',$item->start)->format('d-M-Y');
            $item->finish = Carbon::createFromFormat('Y-m-d',$item->finish)->format('d-M-Y');
        })->all();
    }

    /**
     * @param array $region
     * @return array
     */
    public function past(array $region = []): array {
        return Incentive::getPast($region)->each(function ($item) {
            $item->start = Carbon::createFromFormat('Y-m-d',$item->start)->format('d-M-Y');
            $item->finish = Carbon::createFromFormat('Y-m-d',$item->finish)->format('d-M-Y');
        })->all();
    }

    /**
     * @param array $region
     * @return array
     */
    public function upComing(array $region = []): array {
        return [];
    }

    /**
     * @param $newData
     * @return \App\core\Model|bool|string
     */
    public function update($newData) {
        if(!empty($newData['id'])){
            $incentive = Incentive::find($newData['id']);
        }else{
            $incentive = new Incentive();
        }
        $incentive->title = $newData['title'];
        $incentive->start = $newData['start'];
        $incentive->finish = $newData['finish'];
        $incentive->region = $newData['region'];
        $incentive->caption = $newData['caption'];
        if (isset($newData['image'])) {
            $incentive->image = $newData['image'];
        }
        if (isset($newData['pdf'])) {
            $incentive->pdf = $newData['pdf'];
        }

        return $incentive->save();
    }

    /**
     * @param Incentive $incentive
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Incentive $incentive) {
        return $incentive->delete();
    }
}
