<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'birthdate',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $primaryKey = 'id';

    /**
     * The events where the user is owner, going, ignoring or invited
     */

    public function events()
    {
        return $this->belongsToMany('App\Event', 'event_user', 'id_user', 'id_event')
            ->withPivot('event_user_state');
    }

    public function reports() {
        return $this->hasMany('App\Report', 'id_user', 'id');
    }

}
