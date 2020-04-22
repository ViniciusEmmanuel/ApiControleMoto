<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{

    protected $table = 'parts';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $name;

    protected $description;

}
