<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Generate JWT Token
 * @param array $payload
 * @return string
 */
function generate_jwt($payload) {
    $key = 'mysecretkey'; // Gunakan 1 key yang konsisten di semua fungsi
    $issuedAt = time();
    $expire = $issuedAt + 3600; // Token berlaku 1 jam

    $payload = array_merge($payload, [
        'iat' => $issuedAt,
        'exp' => $expire
    ]);

    return JWT::encode($payload, $key, 'HS256');
}

/**
 * Verify JWT Token
 * @param string $token
 * @return array|null
 */
function verify_jwt($token) {
    $key = 'mysecretkey'; // harus sama dengan key di generate_jwt
    try {
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        return (array) $decoded; // hasilnya array
    } catch (Exception $e) {
        // kamu bisa log error jika ingin
        // log_message('error', 'JWT Error: ' . $e->getMessage());
        return null;
    }
}
