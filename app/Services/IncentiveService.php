<?php

namespace App\Services;

use App\Models\Incentive;
use App\Repositories\IncentiveRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class IncentiveService {

    private $repository;

    public function __construct(IncentiveRepository $incentiveRepository) {
        $this->repository = $incentiveRepository;
     }

    /**
     * @return array
     */
    public function loadIncentivesByPeriod() {
        return [
            'current' => $this->current(),
            'past' => $this->past(),
            'just_finished' => $this->justFinished()
        ];
    }

    /**
     * @param Request $request
     */
    public function updateIncentive(Request $request) {
        $input = $request->input();
        if ($request->hasFile('image')) {
            $imagefileName = $request->image->getClientOriginalName();
            $request->image->storeAs('incentives/images', $imagefileName, 'elite');
            $input['image'] = $imagefileName;
        }
        if ($request->hasFile('pdf')) {
            $pdffileName = $request->pdf->getClientOriginalName();
            $request->pdf->storeAs('incentives/pdfs', $pdffileName, 'elite');
            $input['pdf'] = $pdffileName;
        }
        $this->update($input);
    }

    /**
     * @return mixed
     */
    public function load() {
        return Incentive::get();
    }

    /**
     * @param string $period
     * @param string $region
     * @return array
     */
    public function getIncentives(string $period, string $region) {
        switch ($period) {
            case 'current':
                return $this->current([$region]);
            case 'finished':
                return $this->justFinished([$region]);
            case 'past':
                return $this->past([$region]);
            case 'coming':
                return $this->upComing([$region]);
        }
    }

    /**
     * @param array $region
     * @return array
     */
    public function current(array $region = []): Collection {
        return Incentive::current($region)->get();
    }

    /**
     * @param array $region
     * @return array
     */
    public function justFinished(array $region = []): Collection {
        return Incentive::finished($region)->get()->each(function ($item) {
            $item->start = Carbon::createFromFormat('Y-m-d',$item->start)->format('d-M-Y');
            $item->finish = Carbon::createFromFormat('Y-m-d',$item->finish)->format('d-M-Y');
        });
    }

    /**
     * @param array $region
     * @return array
     */
    public function past(array $region = []): Collection {
        return Incentive::past($region)->get()->each(function ($item) {
            $item->start = Carbon::createFromFormat('Y-m-d',$item->start)->format('d-M-Y');
            $item->finish = Carbon::createFromFormat('Y-m-d',$item->finish)->format('d-M-Y');
        });
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
