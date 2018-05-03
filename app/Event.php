<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $fillable = [
        'title', 'event_visibility', 'event_type',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany('App\User', 'event_user', 'id_event', 'id_user')
            ->withPivot('event_user_state');
    }

}