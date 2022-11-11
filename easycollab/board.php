<?php
session_start();

require "internal/dbconnect.php";
require "internal/functions.php";
require "internal/links.php";

$error_code = 0;

// get board id
$board_id = $_GET['id'];
$boardInfoSql = "SELECT * FROM board WHERE board_id='$board_id'";
$boardInfoResult = mysqli_query($con,$boardInfoSql);
if(mysqli_num_rows($boardInfoResult) > 0)
    $board_info = mysqli_fetch_assoc($boardInfoResult);
else
// if invalid board id, error
    $error_code = 1;

$currentUserId = $_SESSION["user_id"];
    
require "internal/board_navbar.php";

$user_data = check_login($con);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Board View - <?php echo $board_info['board_name'];?></title>
    </head>
    <link rel="stylesheet" href="styles/boardstyle.css">
    <body style="margin-top:75px;" class="mx-3 mx-lg-5">
    <div class="container-fluid">
        <div class="row">
            <?php
            //checking for valid board id
            if($error_code == 1){
                echo '<h1 class="text-center text-danger">Invalid board ID</h1>';
                echo '<div class="text-center"><a class="h4 text-black" href="index.php">Back to Home</a></div>';
            }
            else {
                //checking if user belongs to board
                $currentBoardId = $board_info['board_id'];
                $checkOwnerSql = "SELECT * FROM board WHERE board_id='$currentBoardId' AND board_owner='$currentUserId';";
                $checkJoinedSql = "SELECT * FROM users_board WHERE board_id='$currentBoardId' AND user_id='$currentUserId';";
                $checkOwnerResult = mysqli_query($con,$checkOwnerSql);
                $checkJoinedResult = mysqli_query($con,$checkJoinedSql);

                if(mysqli_num_rows($checkOwnerResult) == 0 && mysqli_num_rows($checkJoinedResult) == 0)
                    $error_code = 2;

                if($error_code == 2){
                    echo '<h1 class="text-center text-danger">Sorry! You do not have access to this board!</h1>';
                    echo '<div class="text-center"><a class="h4 text-black" href="index.php">Back to Home</a></div>';
                }
                else{
                    ?>
                <div class="col-6 p-0 pb-2">
                    <a href="index.php" class="btn btn-lg btn-primary" title="Back to mainpage"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                </div>
                    <h3 style="text-align:center; border-top: 2px solid; padding-bottom:5px; padding-top:5px;"><?php echo $board_info['board_name'];?></h3>
                    <div class="row">
                        <div class="row board-container mx-auto" id="board">
                        </div>
                    </div>
                    <div class="modal fade" id="addtask-modal" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal-title">Add a Task</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="actions/addtask_action.php" method="post">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-7">
                                                <div class="form-group">
                                                    <textarea type="text" class="form-control" rows="4" name="task_title" placeholder="Task Title" pattern="[a-zA-Z0-9 ]+" maxlength="200" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="16" name="task_content" placeholder="Enter your task description here..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="board_id" value="<?php echo $board_id; ?>">
                                        <input type="hidden" name="task_creator_id" value="<?php echo $currentUserId; ?>">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success" name="addtask-submit">Create Task</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
        <script src="scripts/boardscript.js"></script>
    </body>
</html>