<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
    protected $table = 'paths';

    public $timestamps = false;

    protected $primaryKey = 'id';

}