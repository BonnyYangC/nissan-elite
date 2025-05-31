<?php

namespace App\Services;

use App\Repositories\PositionRepository;

class PositionService {

    private $positionRepo;

    public function __construct(PositionRepository $positionRepository) {
        $this->positionRepo = $positionRepository;
    }

    /**
     * @return mixed
     */
    public function getPositions() {
        return $this->positionRepo->loadMembers();
    }

    public function getPositionsWithT() {
        return $this->positionRepo->loadMembersWithT();
    }

}
