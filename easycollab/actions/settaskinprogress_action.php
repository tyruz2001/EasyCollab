<?php
if(isset($_POST['inprogress-submit'])){
    session_start();
    require '../internal/dbconnect.php';

    $board_id = $_POST['board_id'];
    $task_id = $_POST['task_id'];

    $checkBoardSql = "SELECT * FROM board WHERE board_id='$board_id';";
    $checkBoardResult = mysqli_query($con,$checkBoardSql);

    if(mysqli_num_rows($checkBoardResult) > 0){
        $updateStatusSql = "UPDATE tasks SET task_status='in_progress' WHERE task_id = '$task_id' AND board_id = '$board_id'";
        mysqli_query($con,$updateStatusSql);
    }
    header("Location: ../board.php?id=".$board_id);
}
?>