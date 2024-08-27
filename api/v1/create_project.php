<?php
require_once '../../classes/Database.php';
require_once '../../classes/Project.php';
require_once '../../config/jwt.php';
use Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnection();

$project = new Project($db);

$data = json_decode(file_get_contents("php://input"));

// Ensure 'Authorization' header exists and is formatted correctly
$headers = getallheaders();
if (isset($headers['Authorization'])) {
    $jwt = $headers['Authorization'];

    try {
        // Decode the JWT
        $decoded = JWT::decode($jwt, ['HS256']);

        if (!empty($data->project_name) && !empty($data->description)) {
            $project->project_name = $data->project_name;
            $project->description = $data->description;
            $project->user_id = $decoded->data->id; // Make sure 'id' matches the token's payload
            $project->status = $data->status;

            if ($project->create()) {
                http_response_code(201);
                echo json_encode(["message" => "Project created successfully."]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Unable to create project."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Unable to create project. Data is incomplete."]);
        }
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["message" => "Access denied."]);
    }
} else {
    http_response_code(401);
    echo json_encode(["message" => "Access denied."]);
}
?>
