<?php
if(isset($_POST['assignmember-submit'])){
    session_start();
    require '../internal/dbconnect.php';

    $assignEmail = $_POST['assign_email'];
    $assignBoard = $_POST['assign_board'];
    $assignTask = $_POST['assign_task'];

    if(empty($assignEmail))
        header ("Location: ../board.php?id=".$assignBoard);
        else{
            // checking if user is inside the board
            $checkMemberSql = "SELECT * FROM users_board WHERE user_email='$assignEmail';";
            $checkMemberResult = mysqli_query($con,$checkMemberSql);

            if(mysqli_num_rows($checkMemberResult) > 0){
                $checkMemberRow = mysqli_fetch_assoc($checkMemberResult);

                // check if user is in the board
                $checkMemberJoinedSql = "SELECT * FROM users_board WHERE user_id='".$checkMemberRow['user_id']."' AND board_id='$assignBoard';";
                $checkMemberJoinedResult = mysqli_query($con,$checkMemberJoinedSql);

                // check if task is alr assigned to the same member
                $checkAssignedSql = "SELECT * FROM tasks WHERE task_assigned='$assignEmail' AND task_id='$assignTask'";
                $checkAssignedResult = mysqli_query($con,$checkAssignedSql);

                if(mysqli_num_rows($checkMemberJoinedResult) > 0 && mysqli_num_rows($checkAssignedResult) == 0){
                    // assign success
                    $insertAssginedSql = "UPDATE tasks SET task_assigned='$assignEmail' WHERE task_id = '$assignTask' AND board_id = '$assignBoard'";
                    mysqli_query($con,$insertAssginedSql);
                }
            }
        }
        header ("Location: ../task_view.php?task_id=".$assignTask."&id=".$assignBoard);
}
else{
    header("Location: ../index.php");
}
?>