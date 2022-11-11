<?php
if(isset($_POST['leaveboard-submit'])){
    session_start();
    require '../internal/dbconnect.php';

    $currentUserId = $_SESSION["user_id"];
    $leaveId = $_POST['leaveboard-submit'];

    $boardCheckSql = "SELECT id FROM users_board WHERE user_id='$currentUserId' AND board_id='$leaveId';";
    if(mysqli_num_rows(mysqli_query($con,$boardCheckSql)) > 0){
        $leaveBoardSql = "DELETE FROM users_board WHERE user_id='$currentUserId' AND board_id='$leaveId';";
        mysqli_query($con,$leaveBoardSql);
        header("Location: ../index.php");
    }
    else{
        //board was already gone
        header("Location: ../index.php");
    }
}
?>