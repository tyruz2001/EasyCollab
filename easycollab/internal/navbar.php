<?php
if(!isset($_SESSION))
    session_start();

$user_data = check_login($con);
?>

<nav class="fixed-top navbar navbar-expand-md navbar-dark bg-dark px-3 px-lg-5">
    <a href="index.php" class="navbar-brand mb-0 h1"><img class ="d-inline-block align-top" src="img/ezcollab.png" width="40" height="40"><span class="h2">EasyCollab</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a href="index.php" class="nav-link active">Home</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a href="collaborate.php" class="nav-link active">Collaborate
                <?php
                $countInviteSql = "SELECT COUNT(*) FROM invite WHERE invite_to='".$_SESSION['user_email']."'";
                $countInviteRows = mysqli_fetch_array(mysqli_query($con,$countInviteSql));
                $countInviteResult = intval($countInviteRows[0]);

                if($countInviteResult > 0){
                    echo '<span class="badge rounded-pill bg-danger">'.$countInviteResult.'</span>';
                }
                ?>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item active">
                <a href="logout.php" class="nav-link active">Logout</a>
            </li>
        </ul>
    </div>
</nav>