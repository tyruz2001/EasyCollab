<?php
session_start();

require "internal/dbconnect.php";
require "internal/functions.php";
require "internal/links.php";

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $user_email = $_POST['user_email'];
    $user_name = $_POST['user_name'];
    $user_password = $_POST['user_password'];

    if(!empty($user_email) && !empty($user_name) && !empty($user_password))
    {
        $INPUT_ERROR = false;

        $checkEmailSql = "SELECT * FROM users WHERE user_email='$user_email' LIMIT 1;";
        $checkNameSql = "SELECT * FROM users WHERE user_name='$user_name' LIMIT 1;";
        $emailCheckResult = mysqli_fetch_assoc(mysqli_query($con,$checkEmailSql));
        $nameCheckResult = mysqli_fetch_assoc(mysqli_query($con,$checkNameSql));

        if($emailCheckResult){
            echo '<script language="javascript">';
            echo 'alert("E-mail already exists!")';
            echo '</script>';
            $INPUT_ERROR = true;
        }

        else if($nameCheckResult){
            echo '<script language="javascript">';
            echo 'alert("Username already exists!")';
            echo '</script>';
            $INPUT_ERROR = true;
        }

        if($INPUT_ERROR == false){
        $query = "INSERT INTO users (user_name,user_email,user_password) values ('$user_name','$user_email','$user_password')";

        mysqli_query($con, $query);

        header("Location: login.php");
        die;
        }
        
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
    <title>EasyCollab Register</title>
    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body{
            background: rgb(219, 226, 226);
        }
        .row{
            background: white;
            border-radius: 30px;
            box-shadow: 12px 12px 22px grey;
        }
        img{
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
            margin-top: 75px;
        }
        .btn1{
            border: none;
            outline: none;
            height: 50px;
            width: 100%;
            background-color: black;
            color: white;
            border-radius: 4px;
            font-weight: bold;
        }
        .btn1:hover{
            background: white;
            border: 1px solid;
            color: black;
        }
    </style>
  </head>
  <body>
    <section class="form my-4 mx-5">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-lg-5">
                    <img src="img/testing.png" class="img-fluid" alt="">
                </div>
                <div class="col-lg-7 px-5 pt-5">
                    <h1 class = "font-weight-bold py-3">EasyCollab</h1>
                    <h4>Register your account by filling in the fields below</h4>
                    <form method = "post">
                        <div class="form-row">
                            <div class="col-lg-7">
                                <input type = "email" placeholder = "E-mail" name = "user_email" class = "form-control my-3 p-4">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7">
                                <input type = "username" placeholder = "Username (Only letters and numbers)" name = "user_name" class = "form-control my-3 p-4" pattern="[a-zA-Z0-9 ]+">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7">
                                <input type = "password" placeholder = "Password" name = "user_password" class = "form-control my-3 p-4">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7">
                                <button type = "submit" class = "btn1 mt-3 mb-5" name = "register-submit">Register</button>
                            </div>
                        </div>
                        <p>Already have an account? <a href = "login.php">Click here to login!</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
  </body>
</html>