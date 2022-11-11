<?php
if(isset($_POST['deleteboard-submit'])){
    session_start();
    require '../internal/dbconnect.php';

    $deleteBoardId = $_POST['deleteboard-submit'];

    $selectBoardSql = "SELECT * FROM board WHERE board_id='$deleteBoardId'";
    $selectBoardResult = mysqli_query($con,$selectBoardSql);

    if(mysqli_num_rows($selectBoardResult) > 0){
        $deleteBoardSql = "DELETE FROM board WHERE board_id='$deleteBoardId'";
        $deleteMemberSql = "DELETE FROM users_board WHERE board_id='$deleteBoardId'";
        $deleteInviteSql = "DELETE FROM invite WHERE invite_board='$deleteBoardId'";
        $deleteTasksSql = "DELETE FROM tasks WHERE board_id='$deleteBoardId'";
        
        if(mysqli_query($con,$deleteMemberSql) && mysqli_query($con,$deleteInviteSql) && mysqli_query($con,$deleteTasksSql)){
            mysqli_query($con,$deleteBoardSql);
        }
        header("Location: ../index.php");
    }
    else{
        header("Location: ../index.php");
    }
}
?>