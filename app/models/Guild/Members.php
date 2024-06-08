<?php

namespace App\Models\Guild;
use App\Builders\Guild\MembersBuilder;


class Members extends Guild {

    public $table = 'guild_members';

    public function newEloquentBuilder($query): MembersBuilder {
        return new MembersBuilder($query);
    }
}
