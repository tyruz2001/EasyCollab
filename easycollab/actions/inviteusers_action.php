<?php
if(isset($_POST['inviteusers-submit'])){
    session_start();
    require "../internal/dbconnect.php";

    $inviteEmail = $_POST['invite_email'];
    $inviteFrom = $_POST['invite_from'];
    $inviteBoard = $_POST['invite_board'];

    if(empty($inviteEmail))
        header("Location: ../board.php?id=".$inviteBoard);
    else{
        // checking if email belongs to existing user
        $checkUserSql = "SELECT * FROM users WHERE user_email='$inviteEmail';";
        $checkUserResult = mysqli_query($con,$checkUserSql);
    
        if(mysqli_num_rows($checkUserResult) > 0){
            $checkUserRow = mysqli_fetch_assoc($checkUserResult);
            
            // checking if user alr joined board
            $checkUserJoinedSql = "SELECT * FROM users_board WHERE user_id='".$checkUserRow['user_id']."' AND board_id='$inviteBoard';";
            $checkUserJoinedResult = mysqli_query($con,$checkUserJoinedSql);
            
            // checking if invite has alr been sent to the same user
            $checkInvitationSql = "SELECT * FROM invite WHERE invite_board='$inviteBoard' AND invite_to='$inviteEmail';";
            $checkInvitationResult = mysqli_query($con,$checkInvitationSql);
            
            // checking if user is board owner
            $checkOwnerSql = "SELECT * FROM board WHERE board_id='$inviteBoard' AND board_owner='".$checkUserRow['user_id']."';";
            $checkOwnerResult = mysqli_query($con,$checkOwnerSql);

            if(mysqli_num_rows($checkUserJoinedResult) == 0 && mysqli_num_rows($checkInvitationResult) == 0 && mysqli_num_rows($checkOwnerResult) == 0){
                // invite success
                $inviteDatetime = date('Y-m-d H:i:s');
                $insertInviteSql = "INSERT INTO invite(invite_board,invite_to,invite_from,invite_datetime) VALUES('$inviteBoard','$inviteEmail','$inviteFrom','$inviteDatetime');";
                mysqli_query($con,$insertInviteSql);
            }
        }
    }
    header("Location: ../board.php?id=".$inviteBoard);
}
else{
    header("Location: ../index.php");
}
?>