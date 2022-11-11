<?php
if(isset($_POST['joinboard-accept-submit']) || isset($_POST['joinboard-reject-submit'])){
    session_start();
    require '../internal/dbconnect.php';

    $currentUserId = $_SESSION["user_id"];
    $currentUserEmail = $_SESSION["user_email"];
    $currentBoardId = $_POST["joinboard-id"];

    if(isset($_POST['joinboard-accept-submit'])){
        $inviteAcceptId = $_POST['joinboard-accept-submit'];

        // check for dupe
        $dupeBoardSql = "SELECT id FROM users_board WHERE user_id='$currentUserId' AND board_id='$currentBoardId';";
        $dupeBoardResult = mysqli_query($con,$dupeBoardSql);
        if(mysqli_num_rows($dupeBoardResult) > 0){
            // notice for already joined board
            $_SESSION['joinboard-info'] = 1;
        }
        else{
            $joinAcceptSql = "INSERT INTO users_board(user_id,board_id,user_email) VALUES('$currentUserId','$currentBoardId','$currentUserEmail')";
            mysqli_query($con,$joinAcceptSql);
            
            // notice for joined board success
            $_SESSION['joinboard-info'] = 2;
        }
        
        // delete accepted invite
        $delInviteSql = "DELETE FROM invite WHERE invite_id='$inviteAcceptId';";
        mysqli_query($con,$delInviteSql);
    }
    if(isset($_POST['joinboard-reject-submit'])){
        $inviteRejectId = $_POST['joinboard-reject-submit'];
        
        // delete rejected invite
        $delInviteSql = "DELETE FROM invite WHERE invite_id='$inviteRejectId';";
        mysqli_query($con,$delInviteSql);
        
        // notice for rejected invite
        $_SESSION['joinboard-info'] = 3;
    }
    header("Location: ../collaborate.php");
}
else{
    header("Location: ../index.php");
}
?>