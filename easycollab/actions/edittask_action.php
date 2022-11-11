<?php
if(isset($_POST['addtask-submit'])){
    session_start();
    require '../internal/dbconnect.php';

    $board_id = $_POST['board_id'];
    $task_id = $_POST['task_id'];
    $task_editor = $_SESSION['user_name'];
    $task_title = trim($_POST['task_title']);
    $task_content = addslashes($_POST['task_content']);

    if(empty($task_title))
        header("Location: ../board.php?id=".$board_id);
    else{
        // checking if current board still exists
        $checkBoardSql = "SELECT * FROM board WHERE board_id='$board_id';";
        $checkBoardResult = mysqli_query($con,$checkBoardSql);

        if(mysqli_num_rows($checkBoardResult) > 0){
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $task_time_modified = date('Y-m-d H:i:s');

            $updateTaskSql = "UPDATE tasks SET task_editor='$task_editor',task_title='$task_title',task_content='$task_content',task_time_modified='$task_time_modified' WHERE task_id='$task_id';";
            mysqli_query($con,$updateTaskSql);
        }
        else{
            header("Location: ../index.php");
        }
    }
    header("Location: ../task_view.php?task_id=".$task_id."&id=".$board_id);
}
else{
    header("Location: ../index.php");
}
?>