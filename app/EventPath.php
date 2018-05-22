<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPath extends Model
{
    protected $table = 'event_path';

    public $timestamps = false;

    // WARNING - this is not a primary key!
    protected $primaryKey = 'id_path';

}