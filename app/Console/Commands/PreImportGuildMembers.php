<?php

namespace App\Console\Commands;

use App\Models\Guild\Members;
use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Csv\Statement;

class PreImportGuildMembers extends PreImportCsv
{
    protected $signature = 'pre-import:guild-members {theme}';

    protected $description = 'Pre import guild member from csv file';

    protected $fileName = 'guild_members.csv';


    protected function importData()
    {

        $this->connection->table('guild_members')->truncate();
        $successCount = 0;

            $type = 1;
            foreach ($this->data as $lineNumber => $record) {
                if (strstr($record[0], 'PLATINUM MEMBERS')) {
                    //'PLATINUM MEMBERS (500,000+)'
                    $type = 1;
                    continue;
                } else if (strstr($record[0], 'GOLD MEMBERS')) {
                    //'PLATINUM MEMBERS (500,000+)'
                    $type = 2;
                    continue;
                } else if (strstr($record[0], 'LIFETIME MEMBERS')) {
                    //'LIFETIME MEMBERS - RETIRED'
                    $type = 3;
                    continue;
                } else if (strstr($record[0], 'DIAMOND')) {
                    //'DIAMOND CENTURIAN MEMBER (1,000,000+)'
                    var_dump('33333',$record[0]);
                    $type = 4;
                    continue;
                } else if (!$record[0]) {
                    continue;
                }
                Members::factory()->create([
                    'type' => $type,
                    'member' => $record[0],
                    'dealer' => $record[1],
                    'retired' => $record[2]
                ]);
                $successCount++;
            }

            echo 'Guild_members table has updated Success: '.$successCount.PHP_EOL;

    }
}
