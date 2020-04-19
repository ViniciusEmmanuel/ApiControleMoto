<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{

    use Authenticatable, Authorizable;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = true;

    protected $hidden = ['password'];

    protected $userId;

    protected $name;

    protected $password;

    protected $role;

    public function comparePassword($password)
    {

        if (Hash::check($this->password, $password)) {
            return true;
        }

        return false;
    }
}
