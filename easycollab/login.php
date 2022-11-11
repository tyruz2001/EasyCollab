<?php
session_start();

require "internal/dbconnect.php";
require "internal/functions.php";
require "internal/links.php";

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    if(!empty($user_email) && !empty($user_password))
    {
        $query = "SELECT * FROM users WHERE user_email = '$user_email' LIMIT 1";

        $result = mysqli_query($con, $query);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $user_data = mysqli_fetch_assoc($result);
                
                if($user_data['user_password'] === $user_password)
                {
                    //save into session
                    $_SESSION["user_id"] = $user_data['user_id'];
                    $_SESSION["user_email"] = $user_data['user_email'];
                    $_SESSION["user_name"] = $user_data['user_name'];
                    header("Location: index.php");
                    die;
                }
            }
        }
        echo '<script language="javascript">';
        echo 'alert("Username/Password is incorrect! Register if you need an account.")';
        echo '</script>';
    }else
    {
        echo '<script language="javascript">';
        echo 'alert("Please make sure all fields are entered!")';
        echo '</script>';
    }
}
if(isset($_SESSION["user_id"])){
    header("Location: index.php");
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyCollab Login</title>
  </head>
  <link rel="stylesheet" href="styles/loginstyle.css">
  <body>
    <section class="form my-4 mx-5">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-lg-5">
                    <img src="img/testing.png" class="img-fluid" alt="">
                </div>
                <div class="col-lg-7 px-5 pt-5">
                    <h1 class = "font-weight-bold py-3">EasyCollab</h1>
                    <h4>Sign in using your e-mail and password</h4>
                    <form method = "post">
                        <div class="form-row">
                            <div class="col-lg-7">
                                <input type = "email" placeholder = "E-mail" name = "user_email" class = "form-control my-3 p-4">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7">
                                <input type = "password" placeholder = "Password" name = "user_password" class = "form-control my-3 p-4" pattern="[a-zA-Z0-9 ]+">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7">
                                <button type = "submit" class = "btn1 mt-3 mb-5" name = "login-submit">Login</button>
                            </div>
                        </div>
                        <p>Don't have an account? <a href ="registration.php">Click here to register!</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
  </body>
</html>