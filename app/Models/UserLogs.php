<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{

    protected static function booted()
    {
        static::saving(function ($user) {

            $user['token'] = Hash::make($user['token'], [
                'rounds' => 12,
            ]);

        });

        static::updating(function ($user) {

            $user['token'] = Hash::make($user['token'], [
                'rounds' => 6,
            ]);

        });
    }

    protected $table = 'user_logs';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $hidden = ['password'];

    protected $user_id;

    protected $token;

    protected $status;

    public function compareToken($token)
    {

        if (Hash::check($this->token, $token)) {
            return true;
        }

        return false;
    }

}
