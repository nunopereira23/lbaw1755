<?php
/**
 * Created by PhpStorm.
 * User: michaela
 * Date: 1.5.18
 * Time: 1:45
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{

    protected $table = 'event_user';

    public $timestamps = false;

    // WARNING - this is not a primary key!
    protected $primaryKey = 'id_event';

}