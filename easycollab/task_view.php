<?php
session_start();

require "internal/dbconnect.php";
require "internal/functions.php";
require "internal/links.php";

$error_code = 0;

// get board&task id
$board_id = $_GET['id'];
$task_id = $_GET['task_id'];
$boardInfoSql = "SELECT * FROM board WHERE board_id='$board_id'";
$taskInfoSql = "SELECT * FROM tasks WHERE task_id='$task_id'";
$boardInfoResult = mysqli_query($con,$boardInfoSql);
$taskInfoResult = mysqli_query($con,$taskInfoSql);
if(mysqli_num_rows($boardInfoResult) > 0 && mysqli_num_rows($taskInfoResult) > 0){
    $board_info = mysqli_fetch_assoc($boardInfoResult);
    $task_info = mysqli_fetch_assoc($taskInfoResult);
}
else{
// if invalid board/task id, error
    $error_code = 1;
}
$currentUserId = $_SESSION["user_id"];

$user_data = check_login($con);

$checkOwnerSql = "SELECT * FROM board WHERE board_id='$board_id' AND board_owner='$currentUserId'";
$checkJoinedSql = "SELECT * FROM users_board WHERE board_id='$board_id' AND user_id='$currentUserId'";
$checkOwnerResult = mysqli_query($con,$checkOwnerSql);
$checkJoinedResult = mysqli_query($con,$checkJoinedSql);

// get task creator name
$task_creator = $_SESSION['user_name'];
$checkTaskCreatorSql = "SELECT * FROM tasks WHERE task_creator='$task_creator' AND task_id='$task_id'";
$checkTaskCreatorResult = mysqli_query($con,$checkTaskCreatorSql);

// get assigned member email
$task_assigned_email = $_SESSION['user_email'];
$assignedMemberEmailSql = "SELECT * FROM tasks WHERE task_assigned='$task_assigned_email' AND task_id='$task_id'";
$assignedMemberEmailResult = mysqli_query($con,$assignedMemberEmailSql);

if(mysqli_num_rows($checkOwnerResult) > 0 || mysqli_num_rows($checkJoinedResult) > 0){
    require "internal/board_navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task View - <?php echo $task_info['task_title']; ?></title>
</head>
<body style="margin-top:80px;" class="mx-3 mx-lg-5">
    <div class="container-fluid">
        <!-- top of page (back, edit, assign, move, delete) -->
        <div class="row">
            <div class="col-6 p-0">
                <a href="board.php?id=<?php echo $board_id; ?>" class="btn btn-lg btn-primary" title="Back to board"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>
            <?php
            if(mysqli_num_rows($checkTaskCreatorResult) > 0 || mysqli_num_rows($assignedMemberEmailResult) > 0 || mysqli_num_rows($checkOwnerResult) > 0){
                echo'<div class="col-6 text-end p-0">'
                        .'<button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal" title="Edit Task"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Task</button>';
                        if(mysqli_num_rows($checkTaskCreatorResult) > 0 || mysqli_num_rows($checkOwnerResult) > 0){
                        echo'<div class="dropstart">'
                            .'<button type="button" class="btn btn-lg btn-secondary dropdown-toggle" id="dropdownmenuAssign" data-bs-toggle="dropdown" aria-expanded="false" title="Assign Member"><i class="fa fa-solid fa-user-tag" aria-hidden="true"></i> Assign Member</button>'
                            .'<ul class="dropdown-menu p-2" aria-labelledby="dropdownmenuAssign">'
                                .'<form action="actions/assignmember_action.php" method="post">'
                                    .'<input type="email" class="form-control form-control-sm" name="assign_email" placeholder="Enter E-mail" required>'
                                    .'<input type="hidden" name="assign_board" value="'.$board_id.'">'
                                    .'<input type="hidden" name="assign_task" value="'.$task_id.'">'
                                    .'<button type="submit" class="btn btn-success btn-sm" name="assignmember-submit" onclick="return confirm (\'Assign member to this task?\')">Submit</button>'
                                .'</form>'
                            .'</ul>'
                        .'</div>';
                        }
                        echo'<div class="dropstart">'
                            .'<button class="btn btn-lg btn-info dropdown-toggle" type="button" id="dropdownmenuStatus" data-bs-toggle="dropdown" aria-expanded="false" title="Move to Column"><i class="fa-solid fa-table-columns"></i> Move to Column</button>'
                            .'<ul class="dropdown-menu" aria-labelledby="dropdownmenuStatus">'
                                .'<form class="dropdown-item" action="actions/settasknotstarted_action.php" method="post">'
                                .'<button type="submit" name="notstarted-submit" class="btn btn-lg">Not Started</button><input type="hidden" name="board_id" value="'.$board_id.'">
                                <input type="hidden" name="task_id" value="'.$task_id.'">'
                                .'</form>'
                                .'<form class="dropdown-item" action="actions/settaskinprogress_action.php" method="post">'
                                .'<button type="submit" name="inprogress-submit" class="btn btn-lg">In Progress</button><input type="hidden" name="board_id" value="'.$board_id.'">
                                <input type="hidden" name="task_id" value="'.$task_id.'">'
                                .'</form>'
                                .'<form class="dropdown-item" action="actions/settaskinreview_action.php" method="post">'
                                .'<button type="submit" name="inreview-submit" class="btn btn-lg">In Review</button><input type="hidden" name="board_id" value="'.$board_id.'">
                                <input type="hidden" name="task_id" value="'.$task_id.'">'
                                .'</form>'
                                .'<form class="dropdown-item" action="actions/settaskcompleted_action.php" method="post">'
                                .'<button type="submit" name="completed-submit" class="btn btn-lg">Completed</button><input type="hidden" name="board_id" value="'.$board_id.'">
                                <input type="hidden" name="task_id" value="'.$task_id.'">'
                                .'</form>'
                            .'</ul>'
                        .'</div>';
                        if(mysqli_num_rows($checkTaskCreatorResult) > 0 || mysqli_num_rows($checkOwnerResult) > 0){
                        echo'<form action="actions/deletetask_action.php" method="post">'
                        .'<input type="hidden" name="board_id" value="'.$board_id.'">'
                        .'<button type="submit" class="btn btn-lg btn-danger" name="deletetask-submit" value="'.$task_id.'" onclick="return confirm(\'Are you sure you want to delete this task?\')" title="Delete Task"><i class="fa fa-trash" aria-hidden="true"></i> Delete Task</button>'
                        .'</form>';
                        }
                        echo'<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskLabel" aria-hidden="true">'
                            .'<div class="modal-dialog modal-lg modal-dialog-centered" role="document">'
                                .'<div class="modal-content">'
                                    .'<div class="modal-header">'
                                        .'<h5 class="modal-title" id="editTaskLabel">Edit Task</h5>'
                                        .'<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>'
                                    .'</div>'
                                    .'<form action="actions/edittask_action.php" method="post">'
                                        .'<div class="modal-body">'
                                            .'<div class="row">'
                                                .'<div class="col-12 col-sm-7">'
                                                    .'<div class="form-group">'
                                                        .'<textarea type="text" class="form-control" rows="4" name="task_title" placeholder="Task Title" pattern="[a-zA-Z0-9 ]+" maxlength="200" required>'.$task_info['task_title'].'</textarea>'
                                                    .'</div>'
                                                .'</div>'
                                            .'</div>'
                                            .'<div class="row">'
                                                .'<div class="col-12">'
                                                    .'<div class="form-group">'
                                                        .'<textarea class="form-control" rows="16" name="task_content" placeholder="Enter your task description here...">'.$task_info['task_content'].'</textarea>'
                                                    .'</div>'
                                                .'</div>'
                                            .'</div>'
                                        .'</div>'
                                        .'<div class="modal-footer">'
                                            .'<input type="hidden" name="board_id" value="'.$board_id.'">'
                                            .'<input type="hidden" name="task_id" value="'.$task_id.'">'
                                            .'<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>'
                                            .'<button type="submit" class="btn btn-success" name="addtask-submit">Confirm Edit</button>'
                                        .'</div>'
                                    .'</form>'
                                .'</div>'
                            .'</div>'
                        .'</div>'
                    .'</div>';
            }
            ?>
        </div>
        <div class="row my-4">
            <div class="p-0 col-10 col-md-9 col-lg-8 col-xl-6 card mx-auto">
                <p class="h5 card-header font-weight-bold bg-success bg-gradient text-white py-2"><?php echo $task_info['task_title']; ?></p>
                <div class="card-body bg-light">
                    <div class="card-text pb-5">
                        <?php echo $task_info['task_content']; ?>
                    </div>
                    <div class="card-footer text-muted">
                        <i class="fa fa-fw fa-user" aria-hidden="true"></i> Created by: <?php echo $task_info['task_creator']; ?><br>
                        <i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i> Last edited by: <?php echo $task_info['task_editor']; ?><br>
                        <i class="fa fa-fw fa-clock-o" aria-hidden="true"></i> Last modified on: <?php echo $task_info['task_time_modified']; ?><br>
                        <?php
                        echo'<form action="actions/removeassign_action.php" method="post">'
                            .'<i class="fa fa-fw fa-solid fa-user-tag" aria-hidden="true"></i> Assigned to: '.$task_info['task_assigned'].''
                            .'<input type="hidden" name="assign_email" value="'.$task_info['task_assigned'].'">'
                            .'<input type="hidden" name="assign_task" value="'.$task_id.'">'
                            .'<input type="hidden" name="assign_board" value="'.$board_id.'">';
                            if(mysqli_num_rows($checkTaskCreatorResult) > 0 || mysqli_num_rows($checkOwnerResult) > 0){
                                if($task_info['task_assigned'] > 0){
                            echo '<button type="submit" class="btn btn-danger btn-sm pt-0 pb-0" name="removeassign-submit" onclick="return confirm(\'Remove the assigned member from this task?\')">Remove Assign</button>'
                            .'</form>';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
}
else{
    header("Location: index.php");
}
?>