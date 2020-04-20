<?php

namespace App\Services;

use DateInterval;
use DateTime;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class AuthJwt
{

    protected $ip;

    protected $navigator;

    protected $authorization;

    protected $ex;

    public function __construct(Request $request)
    {

        $this->ip = $request->ip();
        $this->userAgent = $request->userAgent();
        $this->authorization = $request->header('authorization');

        $this->ex = (new DateTime())
            ->add(new DateInterval('P7D'))
            ->getTimestamp();

    }

    public function sign($userId)
    {
        $payload = [
            'id' => $userId,
            'ip' => $this->ip,
            'userAgent' => $this->userAgent,
            'ex' => $this->ex,
        ];

        return JWT::encode($payload, env('APP_KEY'));
    }

    public function verify()
    {

        try {

            $bearer = explode(' ', (string) $this->authorization);

            $ip = (int) $this->ip;
            $userAgent = (string) $this->userAgent;

            $decode = (array) JWT::decode($bearer[1], env('APP_KEY'), array('HS256'));

            $date = (new DateTime())->getTimestamp();

            if ($ip !== (int) $decode['ip'] ||
                $userAgent !== $decode['userAgent'] ||
                $date > $decode['ex']) {

                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }

        return true;

    }

}
