<?php
namespace App\Helper;

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use Mockery\Expectation;

class JWTToken
{
    public static function CreateToken($userEmail) : string {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'LaravelToken',
            'iat' => time(),
            'exp' => time()+60*60,
            'userEmail' => $userEmail
        ];

        return JWT::encode($payload, $key, 'HS256');
    }
    
    
    public static function CreateTokenForSetPassword($userEmail) : string {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'LaravelToken',
            'iat' => time(),
            'exp' => time()+60*5,
            'userEmail' => $userEmail
        ];
        return JWT::encode($payload, $key, 'HS256');
    }


    public static function VerifyToken($token) : string {
        try{
            $key = env('JWT_KEY');
            $decode = JWT::decode($token, new Key($key, 'HS256'));
            return $decode->userEmail;
        }
        catch(Expectation $e){
            return "Unauthorized!";
        }
    }
}