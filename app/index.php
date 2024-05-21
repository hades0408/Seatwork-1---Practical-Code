<?php
session_start();

$todoList = array();

if (isset($_SESSION["todoList"])) {
    $todoList = $_SESSION["todoList"];
}

function appendData($task, $todoList) {
    array_push($todoList, $task);
    return $todoList;
}

function deleteData($toDelete, $todoList) {
    foreach ($todoList as $index => $taskName) {
        if ($taskName === $toDelete) {
            unset($todoList[$index]);
            $todoList = array_values($todoList);
            break;
        }
    }
    return $todoList;
}

function clearAllData() {
    return array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["task"])) {
        echo '<script>alert("Error: there is no data to add in array")</script>';
        exit;
    }

    $todoList = appendData($_POST["task"], $todoList);
    $_SESSION["todoList"] = $todoList;
}

if (isset($_GET['task'])) {
    $todoList = deleteData($_GET['task'], $todoList);
    $_SESSION["todoList"] = $todoList;
}

if (isset($_GET['clear']) && $_GET['clear'] == 'true') {
    $todoList = clearAllData();
    $_SESSION["todoList"] = $todoList;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple To-Do List</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .task-container {
            max-width: 600px;
            margin: 50px auto;
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
        }
        .btn-clear {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-clear:hover {
            background-color: #c82333;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container task-container">
        <h1 class="text-center">To-Do List</h1>
        <div class="card mb-4">
            <div class="card-header">Add a New Task</div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="form-group">
                        <input type="text" class="form-control" name="task" placeholder="Enter your task here">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Tasks</div>
            <ul class="list-group list-group-flush">
            <?php
                if (empty($todoList)) {
                    echo '<li class="list-group-item">No tasks available.</li>';
                } else {
                    foreach ($todoList as $task) {
                        echo '<div class="d-flex p-2 bd-highlight w-100 justify-content-between"> 
                              <li class="list-group-item w-100">' . htmlspecialchars($task) . ' </li>
                              <a href="index.php?task=' . urlencode($task) . '" class="btn btn-danger">Delete</a>
                              </div>';
                    }
                }
            ?>
            </ul>
        </div>
        
        <div class="d-flex justify-content-end">
            <a href="index.php?clear=true" class="btn btn-clear">Clear All Tasks</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
