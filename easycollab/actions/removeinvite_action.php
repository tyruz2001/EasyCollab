<?php
if(isset($_POST['removeinvite-submit'])){
    session_start();
    require '../internal/dbconnect.php';

    $inviteId = $_POST['removeinvite-submit'];
    $boardId = $_POST['board_id'];

    $inviteCheckSql = "SELECT * FROM invite WHERE invite_id='$inviteId';";
    if(mysqli_num_rows(mysqli_query($con,$inviteCheckSql)) > 0){
        $removeInviteSql = "DELETE FROM invite WHERE invite_id='$inviteId';";
        mysqli_query($con,$removeInviteSql);
    }
    header("Location: ../board.php?id=".$boardId);
}
else{
    header("Location: ../index.php");
}
?>