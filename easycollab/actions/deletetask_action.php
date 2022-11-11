<?php
if(isset($_POST['deletetask-submit'])){
    session_start();
    require '../internal/dbconnect.php';

    $board_id = $_POST['board_id'];
    $task_id = $_POST['deletetask-submit'];

    $taskCheckSql = "SELECT * FROM tasks WHERE task_id='$task_id';";
    $taskCheckResult = mysqli_query($con,$taskCheckSql);

    if(mysqli_num_rows($taskCheckResult) > 0){
        $deleteTaskSql = "DELETE FROM tasks WHERE task_id='$task_id';";
        mysqli_query($con,$deleteTaskSql);
        header ("Location: ../board.php?id=".$board_id);
    }
}
else{
    header("Location: ../index.php");
}
?>