<?php
session_start();
if (!isset($_SESSION['jwt'])) {
    header('Location: index.php');
    exit();
}

require_once '../classes/Database.php';
require_once '../classes/Project.php';

$database = new Database();
$db = $database->getConnection();
$project = new Project($db);

$project->id = $_GET['id'];
$project->readOne();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Project Details</h2>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title"><?php echo $project->project_name; ?></h5>
                <p class="card-text"><?php echo $project->description; ?></p>
                <p class="card-text"><strong>Status:</strong> <?php echo $project->status; ?></p>
            </div>
        </div>
        <a href="dashboard.php" class="btn btn-primary mt-4">Back to Dashboard</a>
    </div>
</body>
</html>
