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

        $project->readOne();

        if ($project->project_name) {
            $project_arr = array(
                "id" => $project->id,
                "project_name" => $project->project_name,
                "description" => $project->description,
                "status" => $project->status,
                "created_at" => $project->created_at,
                "updated_at" => $project->updated_at
            );

            http_response_code(200);
            echo json_encode($project_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Project not found."));
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
