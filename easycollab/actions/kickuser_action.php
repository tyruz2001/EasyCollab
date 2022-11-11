<?php
if(isset($_POST['kickuser-submit'])){
    session_start();
    require '../internal/dbconnect.php';

    $boardId = $_POST['board_id'];
    $userId = $_POST['kickuser-submit'];

    $userCheckSql = "SELECT * FROM users_board WHERE user_id='$userId' AND board_id='$boardId';";
    if(mysqli_num_rows(mysqli_query($con,$userCheckSql)) > 0){
        $kickUserSql = "DELETE FROM users_board WHERE user_id='$userId' AND board_id='$boardId';";
        mysqli_query($con,$kickUserSql);
    }
    header("Location: ../board.php?id=".$boardId);
}
else{
    header("Location: ../index.php");
}
?>