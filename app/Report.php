<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    protected $fillable = [
        'description',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo('App\User', 'id', 'id_user');
    }

}