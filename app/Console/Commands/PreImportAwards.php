<?php

namespace App\Console\Commands;

use App\Models\{Awards, AwardsType};
use App\Models\Position;

class PreImportAwards extends PreImportCsv
{
    protected $signature = 'pre-import:awards {theme}';

    protected $description = 'Pre import awards status from csv file';
    protected $fileName = 'awards.csv';


    protected function importData()
    {
        $this->connection->table('awards')->truncate();
        $successCount = 0;
        static $type = "";
        static $subType = "";
        static $isGold = false;
        foreach ($this->data as $lineNumber => $record) {
            switch (true)
            {
                case $this->compareType($record[0], AwardsType::PLATINUM_NATIONAL):
                    $type = AwardsType::PLATINUM_NATIONAL;
                    $subType = '';
                    break;
                case in_array($record[0], Awards::nationalAwards):
                    $subType = $record[0];
                    break;
                case $this->compareType($record[0], AwardsType::PLATINUM_STATE):
                    $type = AwardsType::PLATINUM_STATE;
                    $subType = '';
                    break;
                case in_array($record[0], Awards::stateAwards):
                    $subType = $record[0];
                    break;
                case $this->compareType($record[0], AwardsType::GOLD_STATUS):
                    $type = AwardsType::GOLD_STATUS;
                    $subType = '';
                    $isGold = true;
                    break;
                case $isGold && in_array($record[0], Position::members()->pluck('title')->all()):
                    $subType = $record[0];
                    break;
                default:
                    break;

            }
            if (!$record[1]) 
                continue;
            Awards::factory()->create([
                'type' => $type,
                'sub_type' => $subType,
                'position' => $isGold ? null : $record[0],
                'member' => $isGold ? $record[0] : $record[1],
                'dealer' => $isGold ? $record[1] : $record[2],
                'state' => $record[3]
            ]);
            $successCount++;
        }
    }

    private function compareType(string $c1, string $c2) {
        return strstr(strtolower($c1), strtolower($c2));
    }
}
