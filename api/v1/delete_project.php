<?php
require_once '../../classes/Database.php';
require_once '../../classes/Project.php';
require_once '../../config/jwt.php';
use \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnection();

$project = new Project($db);

$data = json_decode(file_get_contents("php://input"));

$jwt = getallheaders()['Authorization'];

if ($jwt) {
    try {
        $decoded = JWT::decode($jwt, JWT_SECRET_KEY, array('HS256'));

        $project->id = $data->id;

        if ($project->delete()) {
            http_response_code(200);
            echo json_encode(array("message" => "Project deleted successfully."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete project."));
        }
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(array("message" => "Access denied."));
    }
} else {
    http_response_code(401);
    echo json_encode(array("message" => "Access denied."));
}
?>
