<?php
require_once '../../classes/Database.php';
require_once '../../classes/Project.php';
require_once '../../config/jwt.php';
use \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnection();

$project = new Project($db);

$jwt = getallheaders()['Authorization'];

if ($jwt) {
    try {
        $decoded = JWT::decode($jwt, JWT_SECRET_KEY, array('HS256'));

        $project->user_id = $decoded->data->id;

        $stmt = $project->readAll();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $projects_arr = array();
            $projects_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $project_item = array(
                    "id" => $project_id,
                    "project_name" => $project_name,
                    "description" => html_entity_decode($description),
                    "status" => $status,
                    "created_at" => $created_at,
                    "updated_at" => $updated_at
                );

                array_push($projects_arr["records"], $project_item);
            }

            http_response_code(200);
            echo json_encode($projects_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No projects found."));
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
