<?php
use \Firebase\JWT\JWT;

define('JWT_SECRET_KEY', 'f22018dbac2c56adeff38b644ac071e3cacca210251a6ad83422e3067ff13abe'); // Replace with your actual secret key

function generateJWT($user_data) {
    $issuedAt = time();
    $expirationTime = $issuedAt + 3600;  // JWT valid for 1 hour from the issued time
    $payload = array(
        'iat' => $issuedAt,
        'exp' => $expirationTime,
        'data' => $user_data
    );

    return JWT::encode($payload, JWT_SECRET_KEY, 'HS256');
}
?>
