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
            } else if (!$record[0]) {
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
