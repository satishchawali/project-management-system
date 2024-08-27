<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';
require_once '../config/jwt.php';
use \Firebase\JWT\JWT;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    if ($user->login()) {
        // Generate JWT
        $token = generateJWT(array("id" => $user->id, "email" => $user->email));
        $_SESSION['jwt'] = $token;
        header('Location: dashboard.php');
        exit();
    } else {
        echo "<script>alert('Login failed. Please check your credentials and try again.');</script>";
    }
}
?>
