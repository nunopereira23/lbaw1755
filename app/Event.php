<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{

    protected $fillable = [
        'title', 'event_visibility', 'event_type', 'gps',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany('App\User', 'event_user', 'id_event', 'id_user')
            ->withPivot('event_user_state');
    }

    public function getPicture() {
        $event_picture_event_path = DB::table('event_path')
            ->where('id_event', $this->id)
            ->first();
        if ($event_picture_event_path != null) {
            $event_picture_path = DB::table('paths')
                ->where('id',$event_picture_event_path->id_path)
                ->first();
            return $event_picture_path->path_value;
        }
        return "../../images/myevent.jpg";

    }

}