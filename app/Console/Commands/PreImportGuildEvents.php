<?php

namespace App\Console\Commands;

use App\Models\Guild\Events;

class PreImportGuildEvents extends PreImportCsv
{
    protected $signature = 'pre-import:guild-events {theme}';

    protected $description = 'Pre import guild events from csv file';

    protected $fileName = 'guild_events.csv';

    protected function importData()
    {
        $this->connection->table('guild_events')->truncate();
        $successCount = 0;

        $type = 1;
        foreach ($this->data as $lineNumber => $record) {
            if (strstr($record[0], 'PLATINUM MEMBERS')) {
                //'PLATINUM MEMBERS (500,000+)'
                var_dump('11111',$record[0]);
                $type = 1;
                continue;
            } else if (strstr($record[0], 'GOLD MEMBERS')) {
                //'PLATINUM MEMBERS (500,000+)'
                var_dump('22222', $record[0]);
                $type = 2;
                continue;
            // } else {
            //     var_dump('33333',$record[0]);
            // }
            } else if (strstr($record[0], 'DIAMOND')) {
                //'DIAMOND centurian(tba) Member (1,000,000+) Million Club'
                var_dump('33333',$record[0]);
                $type = 3;
                continue;
            } else if (!$record[0]) {
                var_dump(value: '44444');
                continue;
            }

            Events::factory()->create([
                'type' => $type,
                'member' => $record[0],
                'dealer' => $record[1]
            ]);
            $successCount++;
        }

        echo 'Guild_events table has updated Success: '.$successCount.PHP_EOL;
    }
}
