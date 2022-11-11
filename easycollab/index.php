<?php
session_start();

require "internal/dbconnect.php";
require "internal/functions.php";
require "internal/links.php";
require "internal/navbar.php";

$user_data = check_login($con);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Homepage</title>
    </head>
    <link rel="stylesheet" href="styles/indexstyle.css">
    <body style="margin-top:80px;" class="mx-3 mx-lg-5">
        <div class="container-fluid">
            <div class="row pb-3 mb-3" style="border-bottom: 2px solid;">
                <h1 style="text-align:center;">Welcome to EasyCollab.</h1>
                <h4 style="text-align:center;">You're signed in as, <?php echo $user_data['user_name']; ?>.</h4>
            </div>
            <div class="row pb-3 mb-3">
                <div class="col-12">
                    <h3 class="pb-3" style="border-bottom: 1px solid;">Create/View Your Boards</h3>
                    <form class="pb-2 my-2 form-inline" action="actions/addboard_action.php" method="post" style="border-bottom: 1px solid;">
                        <input type="text" class="form-control" name="addboard_name" placeholder="Add New (Only letters and numbers)" pattern="[a-zA-Z0-9 ]+" maxlength="50" required>
                        <button type="submit" class="btn btn-success" name="addboard-submit" onclick="return confirm('Create board?')" title="Add board"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </form>
                    <?php
                    $currentUserId = $_SESSION["user_id"];
                    $boardSql = "SELECT * FROM board WHERE board_owner='$currentUserId'";

                    if($boardResult = mysqli_query($con,$boardSql)){
                        if(mysqli_num_rows($boardResult) > 0){
                            while($row = mysqli_fetch_assoc($boardResult)){
                                echo '<div class="btn-group">'
                                    . '<a href="board.php?id='.$row['board_id'].'" class="btn btn-primary btn-block">';
                                        if(strlen($row['board_name']) > 35){
                                            echo substr($row['board_name'],0,35).'...';
                                        }
                                        else{
                                            echo $row['board_name'];
                                        }
                                echo '</a>'
                                    . '<form action="actions/deleteboard_action.php" method="post">'
                                        . '<button type="submit" title="Delete '.$row['board_name'].'" onclick="return confirm(\'Are you sure you want to delete '.$row['board_name'].'?\nEverything will be gone and everyone that has joined this board will lose everything here!\')" name="deleteboard-submit" value="'.$row['board_id'].'" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>'
                                    . '</form>'
                                    . '<div class="dropdown">'
                                        . '<button class="btn btn-secondary dropdown-toggle" type="button" title="Rename '.$row['board_name'].'" id="editBoardName" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-pencil" aria-hidden="true"></i> </button>'
                                        . '<div class="dropdown-menu" aria-labelledby="editBoardName">'
                                            . '<form class="form-inline p-2" action="actions/renameboard_action.php" method="post">'
                                                . '<input type="text" class="form-control form-control-sm" name="editboard_name" placeholder="Edit Board Name" value="'.$row['board_name'].'" pattern="[a-zA-Z0-9 ]+" maxlength="50" required>'
                                                . '<button type="submit" title="Save" class="btn btn-sm btn-success" name="renameboard-submit" value="'.$row['board_id'].'" onclick="return confirm(\'Confirm rename?\')"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>'
                                            . '</form>'
                                        . '</div>'
                                    . '</div>'
                                   . '</div><br>';
                            }
                        }
                        else{
                            echo '<h4 class="text-danger">No boards found.</h4>';
                            echo '<h6 class="text-danger">Create a board by typing the name and clicking the "+" sign above.</h6>';
                        }
                    }
                    ?>
                </div>
                <div>
                    <h3 class="pb-3 mb-3 pt-3 mt-3" style="border-top: 1px solid; border-bottom: 1px solid;">Joined Boards</h3>
                    <?php
                        $currentEmail = $_SESSION["user_email"];
                        $joinedBoardsSql = "SELECT * FROM users_board WHERE user_id=(SELECT user_id FROM users WHERE user_email='$currentEmail');";

                        if($joinedBoardsResult = mysqli_query($con,$joinedBoardsSql)){
                            if(mysqli_num_rows($joinedBoardsResult) > 0){
                                while($row = mysqli_fetch_array($joinedBoardsResult)){
                                    $currentBoardId = $row['board_id'];
                                    $boardNameSql = "SELECT board_name FROM board WHERE board_id='$currentBoardId';";
                                    $row_board = mysqli_fetch_assoc(mysqli_query($con,$boardNameSql));

                                    echo '<div class="btn-group">'
                                        . '<a href="board.php?id='.$row['board_id'].'" class="btn btn-info">';
                                            if(strlen($row_board['board_name']) > 35){
                                                echo substr($row_board['board_name'],0,35).'...';
                                            }
                                            else{
                                                echo $row_board['board_name'];
                                            }
                                    echo '</a>'
                                        . '<form action="actions/leaveboard_action.php" method="post">'
                                        . '<button type="submit" title="Leave '.$row_board['board_name'].'" onclick="return confirm(\'Are you sure you want to leave this board?\')" name="leaveboard-submit" value="'.$row['board_id'].'" class="btn btn-danger"><i class="fa fa-sign-out" aria-hidden="true"></i></a>'
                                        . '</form>'
                                        . '</div><br>';
                                }
                            }
                            else{
                                echo '<h4 class="text-danger">You have not joined any boards.</h4>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>

