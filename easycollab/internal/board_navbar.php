<?php
if(!isset($_SESSION))
    session_start();

$user_data = check_login($con);
?>

<nav class="fixed-top navbar navbar-expand-md navbar-dark bg-dark px-3 px-lg-5">
    <a href="index.php" class="navbar-brand mb-0 h1"><img class ="d-inline-block align-top" src="img/ezcollab.png" width="40" height="40"><span class="h2">EasyCollab</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon">
        <?php
            // checking if the current user is the board owner
            $currentUserId = $user_data['user_id'];
            $currentBoardId = $board_info['board_id'];
            $ownerFormSql = "SELECT * FROM board WHERE board_id='$currentBoardId' AND board_owner='$currentUserId';";
            $ownerFormResult = mysqli_query($con,$ownerFormSql);
        ?>
    </span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a href="index.php" class="nav-link active">Home</a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <?php
            // if current user is board owner allow invite feature
            if(mysqli_num_rows($ownerFormResult) == 1){
                echo '<li class="nav-item dropdown">'
                        . '<a href="#" class="nav-link dropdown-toggle" id="inviteusersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">'
                            . 'Invite Users To Board'
                        . '</a>'
                        . '<ul class="dropdown-menu p-2" aria-labelledby="inviteusersDropdown">'
                            . '<form action="actions/inviteusers_action.php" method="post">'
                                . '<input type="email" class="form-control form-control-sm" name="invite_email" placeholder="Enter E-mail" required>'
                                . '<input type="hidden" name="invite_board" value="'.$board_info['board_id'].'">'
                                . '<input type="hidden" name="invite_from" value="'.$_SESSION['user_email'].'">'
                                . '<button type="submit" class="btn btn-success btn-sm" name="inviteusers-submit" onclick="return confirm(\'Invite this user?\')">Submit</button>'
                            . '</form>'
                        . '</ul>'
                    . '</li>';
            }
            ?>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="pendinginvitationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    View Pending Invitations In Board
                </a>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="pendinginvitationsDropdown">
                    <?php
                        $currentBoardId = $board_info['board_id'];
                        $boardInviteSql = "SELECT invite_to,invite_id FROM invite WHERE invite_board='$currentBoardId';";

                        if($boardInviteResult = mysqli_query($con,$boardInviteSql)){
                            if(mysqli_num_rows($boardInviteResult) > 0){
                                while($row = mysqli_fetch_assoc($boardInviteResult)){
                                    echo '<a class="dropdown-item pb-0" href="#">'
                                        . '<span><i class="fa fa-fw fa-envelope" aria-hidden="true"></i> '.$row['invite_to'].'</span>';
                                    //if board owner, allow to reject invites
                                    if(mysqli_num_rows($ownerFormResult) > 0){
                                        echo '<form class="d-inline-block" action="actions/removeinvite_action.php" method="post">'
                                            . '<input type="hidden" name="board_id" value="'.$board_info['board_id'].'">'
                                            . '<button type="submit" onclick="return confirm(\'Remove invitation for '.$row['invite_to'].'?\')" name="removeinvite-submit" value="'.$row['invite_id'].'" class="ml-1 btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>'
                                            . '</form>';
                                }
                                echo '</a>';
                            }
                        }
                    }
                    ?>
                </ul>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="userlistDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    List Of Members In Board
                </a>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="userlistDropdown">
                <?php
                        $currentBoardId = $board_info['board_id'];
                        $memberSql = "SELECT user_id FROM users_board WHERE board_id='$currentBoardId';";

                        if($memberResult = mysqli_query($con,$memberSql)){
                            if(mysqli_num_rows($memberResult) > 0){
                                while($row = mysqli_fetch_assoc($memberResult)){
                                    $currentMemberId = $row['user_id'];
                                    $usernameSql = "SELECT user_name,user_email FROM users WHERE user_id='$currentMemberId';";
                                    $usernameResult = mysqli_query($con,$usernameSql);
                                    $userRow = mysqli_fetch_assoc($usernameResult);

                                    echo '<a class="dropdown-item pb-0" href="#" title="'.$userRow['user_email'].'">'
                                        . '<span><i class="fa fa-fw fa-user" aria-hidden="true"></i> '.$userRow['user_name'].'</span>';
                                    //if board owner, allow to kick users
                                    if(mysqli_num_rows($ownerFormResult) > 0){
                                        echo '<form class="d-inline-block" action="actions/kickuser_action.php" method="post">'
                                            . '<input type="hidden" name="board_id" value="'.$board_info['board_id'].'">'
                                            . '<button type="submit" onclick="return confirm(\'Are you sure you want to kick '.$userRow['user_name'].'?\')" name="kickuser-submit" value="'.$currentMemberId.'" class="ml-1 btn btn-sm btn-danger"><i class="fa fa-sign-out" aria-hidden="true"></i></button>'
                                            . '</form>';
                                    }
                                    echo '</a>';
                                }
                            }
                        }
                    ?>
                </ul>
            </li>
        </ul>
    </div>
</nav>