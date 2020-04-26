<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;
use Ramsey\Uuid\Uuid;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{

    use Authenticatable, Authorizable;

    protected static function booted()
    {
        static::saving(function ($user) {

            $user['id'] = Uuid::uuid4();
            $user['password'] = Hash::make($user['password'], [
                'rounds' => 12,
            ]);

        });

        static::updating(function ($user) {

            $user['password'] = Hash::make($user['password'], [
                'rounds' => 12,
            ]);

        });
    }

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $keyType = 'char';

    public $incrementing = false;

    public $timestamps = true;

    protected $hidden = ['password'];

    protected $id;

    protected $user;

    protected $name;

    protected $password;

    protected $role;

    public static function comparePassword($dbPassword, $password)
    {

        if (Hash::check($password, $dbPassword)) {
            return true;
        }

        return false;
    }
}
