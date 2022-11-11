<?php
if(isset($_POST['removeassign-submit'])){
    session_start();
    require '../internal/dbconnect.php';

    $assignEmail = $_POST['assign_email'];
    $assignTask = $_POST['assign_task'];
    $assignBoard = $_POST['assign_board'];

    $removeAssignedSql = "UPDATE tasks SET task_assigned=null WHERE task_id = '$assignTask' AND board_id = '$assignBoard' AND task_assigned='$assignEmail'";
    mysqli_query($con,$removeAssignedSql);
    header ("Location: ../task_view.php?task_id=".$assignTask."&id=".$assignBoard);
}
else{
    header("Location: ../index.php");
}
?>