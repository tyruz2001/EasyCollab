<?php
if(isset($_POST['renameboard-submit'])){
    session_start();
    require '../internal/dbconnect.php';

    $board_id = $_POST['renameboard-submit'];
    $board_newname = trim($_POST['editboard_name']);

    if(empty($board_newname))
        header("Location: ../index.php");
    else{
        // check if board is still in the system
        $checkBoardSql = "SELECT * FROM board WHERE board_id='$board_id';";
        $checkBoardResult = mysqli_query($con,$checkBoardSql);

        if(mysqli_num_rows($checkBoardResult) > 0){
            $updateNameSql = "UPDATE board SET board_name='$board_newname' WHERE board_id='$board_id';";
            mysqli_query($con,$updateNameSql);
        }
    }
    header("Location: ../index.php");
}
else{
    header("Location: ../index.php");
}
?>