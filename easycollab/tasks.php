<?php
session_start();
require 'internal/dbconnect.php';

$board_id = $_GET['id'];

$currentUserEmail = $_SESSION['user_email'];

echo '<div class="status" id="not_started">'
        . '<h2>Not Started</h2>'
        . '<button id="add_task_btn" data-bs-toggle="modal" data-bs-target="#addtask-modal">+ Add Task</button>';
            $getTasksNotstartedSql = "SELECT * FROM tasks WHERE board_id='$board_id' AND task_status='not_started' ORDER BY task_time_modified DESC;";
            $getTasksNotstartedResult = mysqli_query($con,$getTasksNotstartedSql);
            if(mysqli_num_rows($getTasksNotstartedResult) > 0){
            foreach($getTasksNotstartedResult as $row){
                if ($row['task_assigned'] == $currentUserEmail){
                    echo '<div class="task bg-info">';
                }else{
                    echo '<div class="task">';
                }
                    echo '<a href="task_view.php?task_id='.$row['task_id'].'&id='.$board_id.'" class="text-dark text-break text-decoration-none stretched-link">'.$row['task_title']
                    .'</a>'
                    . '</div>';
            }
        }
echo  '</div>'
    . '<div class="status" id="in_progress">'
        . '<h2>In Progress</h2>';
            $getTasksInprogressSql = "SELECT * FROM tasks WHERE board_id='$board_id' AND task_status='in_progress' ORDER BY task_time_modified DESC;";
            $getTasksInprogressResult = mysqli_query($con,$getTasksInprogressSql);
            if(mysqli_num_rows($getTasksInprogressResult) > 0){
            foreach($getTasksInprogressResult as $row){
                if ($row['task_assigned'] == $currentUserEmail){
                    echo '<div class="task bg-info">';
                }else{
                    echo '<div class="task">';
                }
                    echo '<a href="task_view.php?task_id='.$row['task_id'].'&id='.$board_id.'" class="text-dark text-break text-decoration-none stretched-link">'.$row['task_title']
                    .'</a>'
                    . '</div>';
            }
        }
echo  '</div>'
    . '<div class="status" id="in_review">'
        . '<h2>In Review</h2>';
        $getTasksInreviewSql = "SELECT * FROM tasks WHERE board_id='$board_id' AND task_status='in_review' ORDER BY task_time_modified DESC;";
            $getTasksInreviewResult = mysqli_query($con,$getTasksInreviewSql);
            if(mysqli_num_rows($getTasksInreviewResult) > 0){
            foreach($getTasksInreviewResult as $row){
                if ($row['task_assigned'] == $currentUserEmail){
                    echo '<div class="task bg-info">';
                }else{
                    echo '<div class="task">';
                }
                    echo '<a href="task_view.php?task_id='.$row['task_id'].'&id='.$board_id.'" class="text-dark text-break text-decoration-none stretched-link">'.$row['task_title']
                    .'</a>'
                    . '</div>';
            }
        }
echo  '</div>'
    . '<div class="status" id="completed">'
        . '<h2>Completed</h2>';
            $getTasksCompletedSql = "SELECT * FROM tasks WHERE board_id='$board_id' AND task_status='completed' ORDER BY task_time_modified DESC;";
            $getTasksCompletedResult = mysqli_query($con,$getTasksCompletedSql);
            if(mysqli_num_rows($getTasksCompletedResult) > 0){
            foreach($getTasksCompletedResult as $row){
                if ($row['task_assigned'] == $currentUserEmail){
                    echo '<div class="task bg-info">';
                }else{
                    echo '<div class="task">';
                }
                    echo '<a href="task_view.php?task_id='.$row['task_id'].'&id='.$board_id.'" class="text-dark text-break text-decoration-none stretched-link">'.$row['task_title']
                    .'</a>'
                    . '</div>';
            }
        }
echo  '</div>';
?>