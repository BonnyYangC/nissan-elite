<?php

namespace App\Models\Guild;
use App\Builders\Guild\EventsBuilder;


class Events extends Guild {

    public $table = 'guild_events';

    public function newEloquentBuilder($query): EventsBuilder {
        return new EventsBuilder($query);
    }
}
