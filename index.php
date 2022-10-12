<?php
    //connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'test_app');

    //variables
    $tasks = mysqli_query($db, "SELECT * FROM tasks");
    $errors = "";

    //add a task
    if (isset($_POST['submit'])){
        $task = $_POST['task'];
        if (empty($task)) {
            $errors = "Please add a task first";
        }else {
            mysqli_query($db, "INSERT INTO tasks (task) VALUES ('$task')");
            header('location: index.php');
        }
    }

    //delete a task
    if (isset($_GET['del_task'])) {
        $id = $_GET['del_task'];
        mysqli_query($db, "DELETE FROM tasks WHERE id = $id");
        header('location: index.php');        
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>test_app_todo</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <div class="heading">
            <h2>To-Do List</h2>
        </div>
        <form method="POST" action="index.php">
            <?php if (isset($errors)) { ?>
                <p><?php echo $errors; ?></p>
            <?php } ?> 
                <input type="text" name="task" class="task_input" placeholder="This field is required">
                <button type="submit" class="add_btn" name="submit">Add Task</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Nr</th>
                    <th>Task</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td class="task"><?php echo $row['task']; ?></td>
                        <td class="delete">
                            <a href="index.php?del_task=<?php echo $row['id']; ?>">x</a>
                    </td>
                </tr>
                <?php $i++; } ?>
            </tbody>
        </table>
    </body>
</html>