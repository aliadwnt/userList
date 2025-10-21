<?php
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class JwtLibrary {
    private $key = "userSecret"; 

    public function generateToken($data)
    {
        $payload = array(
            "iss" => "http://localhost", // issuer
            "aud" => "http://localhost", // audience
            "iat" => time(), // issued at
            "exp" => time() + (60*60), // expired in 1 hour
            "data" => $data
        );

        return JWT::encode($payload, $this->key, 'HS256');
    }

    public function decodeToken($jwt)
    {
        try {
            $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));
            return (array) $decoded->data;
        } catch (Exception $e) {
            return null;
        }
    }
}
