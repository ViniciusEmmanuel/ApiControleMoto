<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gasoline extends Model
{

    protected $table = 'gasoline';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $hidden = ['user_id'];

    protected $user_id;

    protected $motorcicle_id;

    protected $date;

    protected $km;

    protected $liters;

    protected $price;

    protected $deleted;

}
