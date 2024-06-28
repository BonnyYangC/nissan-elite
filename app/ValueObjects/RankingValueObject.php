<?php

namespace App\ValueObjects;
use App\Helper\Role;
use App\Models\Ranking;

final class RankingValueObject {
  var $role;
  var $positions = [];
  var $action;
  var $awardType;

  public function __construct($role, $action, $awardType) {
    $this->role = $role;
    $this->action = $action;
    $this->awardType = $awardType;
  }

  public function __get($name) {
    switch($name) {
      case 'positions':
        return $this->role === Role::TECHNICIAN ? [Role::MASTER_TECHNICIAN, Role::ADVANCED_TECHNICIAN] : [$this->role];
      case 'action':
        return $this->action;
      case 'awardType':
        return $this->awardType ?? Ranking::AWARD_STATUS;;
      default:
        break;
    }
  }
}