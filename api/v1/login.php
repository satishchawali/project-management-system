<?php
session_start();
require_once '../../classes/Database.php';
require_once '../../classes/User.php';
require_once '../../config/jwt.php'; // Ensure this file contains the generateJWT function
use \Firebase\JWT\JWT;

header("Content-Type: application/json; charset=UTF-8");

// Database and User initialization
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Read and decode the input
$input = file_get_contents("php://input");
$data = json_decode($input);

// Debugging output
file_put_contents('debug.log', print_r($data, true), FILE_APPEND);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid JSON format."));
    exit();
}

// Validate and assign data
if (!empty($data->email) && !empty($data->password)) {
    $user->email = $data->email;
    $user->password = $data->password;

    // Attempt to log in
    $loginSuccess = $user->login();
    
    // Debugging output
    file_put_contents('debug.log', "Login Success: " . ($loginSuccess ? "true" : "false") . "\n", FILE_APPEND);
    file_put_contents('debug.log', "User ID: " . ($user->id ?? 'Not Set') . "\n", FILE_APPEND);

    if ($loginSuccess) {
        // Generate JWT
        $token = generateJWT(array("id" => $user->id, "email" => $user->email));
        echo json_encode(array("token" => $token));
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Login failed. Invalid email or password."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data. Please provide both email and password."));
}
?>
