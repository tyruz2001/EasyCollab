<?php
if(isset($_POST['addboard-submit'])){
    session_start();
    require '../internal/dbconnect.php';
    
    $boardname = trim($_POST['addboard_name']);
    
    if(empty($boardname))
        header("Location: ../index.php");
    else{
        //use saved user_id from the session to make current user_id as a board_owner
        $currentUserId = $_SESSION["user_id"];
        //generate unique id
        $board_id = md5(uniqid($currentUserId,true));
        $insertSql = "INSERT INTO board(board_id,board_name,board_owner) VALUES('$board_id','$boardname','$currentUserId');";
        mysqli_query($con,$insertSql);
        header("Location: ../index.php");
    }
}
else{
    header("Location: ../index.php");
}
?>