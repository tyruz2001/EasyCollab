<?php
session_start();

require "internal/dbconnect.php";
require "internal/functions.php";
require "internal/links.php";
require "internal/navbar.php";

$user_data = check_login($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collaborate</title>
</head>
<body style="margin-top:80px;" class="mx-3 mx-lg-5">
    <div class="container-fluid">
        <div class="card bg-dark border-dark text-white mb-4" style="margin:0 20%;">
            <div class="card-header">Invitations</div>
            <div class="card-body">
                <?php
                    if(isset($_SESSION['joinboard-info'])){
                        $joinboard_info = $_SESSION['joinboard-info'];

                        switch($joinboard_info){
                            case 1:
                                echo "<span class=\"text-warning mb-3\">You have already joined that board, the invitation will be deleted.</span>";
                                break;
                            case 2:
                                echo "<span class=\"text-success mb-3\">Invitation accepted and successfully joined board.</span>";
                                break;
                            case 3:
                                echo "<span class=\"text-danger mb-3\">Invitation rejected.</span>";
                                break;
                        }
                        echo '<div class="mb-3"></div>';
                        
                        unset($_SESSION['joinboard-info']);
                    }

                    $currentEmail = $_SESSION['user_email'];
                    $inviteSql = "SELECT * FROM invite WHERE invite_to='$currentEmail' ORDER BY invite_datetime DESC;";

                    if($inviteResult = mysqli_query($con,$inviteSql)){
                        if(mysqli_num_rows($inviteResult) > 0){
                            while($row = mysqli_fetch_assoc($inviteResult)){
                                $nameSql = "SELECT user_name FROM users WHERE user_email='".$row['invite_from']."'";
                                $nameRow = mysqli_fetch_assoc(mysqli_query($con,$nameSql));
                                $senderName = $nameRow['user_name'];
                                $senderEmail = $row['invite_from'];

                                $boardnameSql = "SELECT board_name FROM board WHERE board_id='".$row['invite_board']."'";
                                $boardRow = mysqli_fetch_assoc(mysqli_query($con,$boardnameSql));
                                $boardName = $boardRow['board_name'];

                                echo '<div class="row mb-4">';
                                    echo '<div class="col-12 col-md-7 text-wrap">';
                                        echo '<i class="fa fa-user fa-fw" aria-hidden="true"></i> <b>From: '.$senderName.'</b><br>';
                                        echo '<i class="fa fa-envelope fa-fw" aria-hidden="true"></i> <b>Email: '.$senderEmail.'</b><br>';
                                        echo '<i class="fa fa-sticky-note fa-fw" aria-hidden="true"></i> <b>Board Name: '.$boardName.'</b><br>';
                                        echo '<i class="fa fa-clock-o fa-fw" aria-hidden="true"></i> <b>'.$row['invite_datetime'].'</b><br>';
                                    echo '</div>';
                                    echo '<div class="col-12 col-md-5 mt-2 my-md-auto text-end">';
                                        echo '<form action="actions/joinboard_action.php" method="post">';
                                            echo '<div class="btn-group" role="group">';
                                                echo '<input type="hidden" name="joinboard-id" value="'.$row['invite_board'].'">';
                                                echo '<button type="submit" onclick="return confirm(\'Join this board?\')" name="joinboard-accept-submit" value="'.$row['invite_id'].'" class="btn btn-success">Accept</button>';
                                                echo '<button type="submit" onclick="return confirm(\'Reject join invitation?\')" name="joinboard-reject-submit" value="'.$row['invite_id'].'" class="btn btn-danger">Reject</button>';
                                            echo '</div>';
                                        echo '</form>';
                                    echo '</div>';
                                echo '</div>';
                            }
                        }
                        else{
                            echo '<h4 class="text-white text-center">You have no pending invitations.</h4>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>