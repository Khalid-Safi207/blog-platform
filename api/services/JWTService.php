<?php

require_once __DIR__.'/../lib/php-jwt/src/JWT.php';
require_once __DIR__.'/../lib/php-jwt/src/Key.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class JWTService {

    private $secret = "your_super_long_random_secret_key_123456789";

    public function generateToken($user_id) {

        $payload = [
            "iss" => "your-app",
            "aud" => "your-app-users",
            "iat" => time(),
            "exp" => time() + 3600,
            "user_id" => $user_id
        ];

        return JWT::encode($payload, $this->secret, 'HS256');
    }

    public function validateToken($token) {
        try {
            return JWT::decode($token, new Key($this->secret, 'HS256'));
        } catch (Exception $e) {
            return false;
        }
    }
}