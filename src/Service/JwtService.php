<?php

namespace App\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;

class JwtService
{
    public function __construct(private readonly string $key)
    {
    }

    public function encode(array $payload): string
    {
        return JWT::encode($payload, $this->key, 'HS256');
    }
    public function decode(string $token): ?stdClass
    {
         try{
             return JWT::decode($token, new Key($this->key, 'HS256'));
         } catch (\Exception $exception){
             return null;
         }
    }
}
