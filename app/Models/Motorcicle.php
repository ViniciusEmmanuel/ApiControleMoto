<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motorcicle extends Model
{

    protected $table = 'motorcicles';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $board;

    protected $description;

}
