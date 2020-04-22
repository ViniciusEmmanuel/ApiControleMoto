<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{

    protected $table = 'maintenance';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $hidden = ['user_id'];

    protected $user_id;

    protected $motorcicle_id;

    protected $part_id;

    protected $date;

    protected $km;

    protected $price;

    protected $mechanic;

    protected $deleted;

}
