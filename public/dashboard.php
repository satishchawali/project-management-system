<?php
session_start();
if (!isset($_SESSION['jwt'])) {
    header('Location: index.php');
    exit();
}

require_once '../config/config.php';
require_once '../config/jwt.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Dashboard</h2>

        <!-- Create Project Form -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Create New Project</h5>
                <form id="createProjectForm">
                    <div class="mb-3">
                        <label for="projectName" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="projectName" name="projectName" required>
                    </div>
                    <div class="mb-3">
                        <label for="projectDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="projectDescription" name="projectDescription"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Project</button>
                </form>
            </div>
        </div>

        <!-- Projects List -->
        <div id="projectsList" class="mt-4">
            <!-- Projects will be loaded here by AJAX -->
        </div>

        <!-- Logout Button -->
        <a href="logout.php" class="btn btn-danger mt-4">Logout</a>
    </div>

    <script src="../js/scripts.js"></script>
</body>
</html>
