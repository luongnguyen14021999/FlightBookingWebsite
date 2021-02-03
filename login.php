<?php
session_start();
?>
<?php
require_once("dbconn.php");
if(isset($_POST['Login']))
{
    if(empty($_POST['email']) || empty($_POST['password']))
    {
        header("location: login.php?Empty= **Please fill in the spaces");
    } else {
        $password = $_POST['password'];
        $email = $_POST['email'];
        $passwordWithAlgotithm = hash("sha256", $password);
        $sql = "select * from customer where email = '".$email."' and password = '".$password."'";
        $result = mysqli_query($dbConn,$sql);
        $row = mysqli_num_rows($result);
        if($row > 0)
        {
            $_SESSION['email'] = $email;
            header("location: index.php");
        }
        else {
            header("location: login.php?Invalid= **Please enter correct password and email");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href = "style.css" rel = "stylesheet" type = "text/css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <title>Web Application</title>
    <style>
        html {
            height: 100%;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        header {
            background-image: url("flight.jpeg");
            background-size: cover;
            height: 150vh;
            background-position: center;
        }

        ul {
            float: right;
            list-style-type: none;
        }

        ul li {
            display: inline-block;
        }

        ul li a {
            text-decoration: none;
            color: white;
            padding: 5px 20px;
            border: 1px solid transparent;
            transition: 0.6s ease;
        }

        ul li a:hover {
            background-color: gray;
            color: white;
        }

        .logo img {
            float: left;
            width: 15%;
            height: auto;
            margin-top: 1%;
            margin-left: 5%;
        }

        .login-box {
            width: 50%;
            height: 80%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            text-align: center;
        }

        .login-box h1 {
            color: black;
            text-transform: uppercase;
            font-size: 500%;
            text-align: center;
            font-family: font-family: 'Raleway', sans-serif;
        }

        .login-box input[type="text"], .login-box input[type="password"] {
            border: 0;
            display: block;
            margin: 8% auto;
            text-align: left;
            border: 2px solid cornflowerblue;
            color: white;
            border-radius: 24px;
            transition: 0.25s;
            height: 40px;
            width: 50%;
            font-size: 20px;
            color: black;
        }

        .login-box input[type="text"]:focus, .login-box input[type="password"]:focus {
            width: 80%;
            border-color: cornflowerblue;
        }

        .login-box button {
            border: 0;
            display: block;
            margin: 8% auto;
            text-align: center;
            border: 2px solid cornflowerblue;
            color: black;
            border-radius: 24px;
            transition: 0.25s;
            height: 40px;
            width: 20%;
            font-size: 20px;
        }

        p {
            text-align: center;
            font-size: 150%;
            font-family: 'Raleway', sans-serif;
            color: greenyellow;
        }

        a {
            font-size: 150%;
            font-family: 'Raleway', sans-serif;
            color: blue;
        }

        .login-box button:hover {
            background: lightcoral;
        }

        .alert {
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>
<header>
<div class="mainLogin">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="register.php">Sign Up</a></li>
        <li><a href="#">Help</a></li>
        <li><a href="#">Download</a></li>
    </ul>
</div>
<form id="login" action="login.php" method="post">
    <div class="login-box">

        <h1>Login</h1>

        <?php
        if(@$_GET['Empty'] == true)
        {
            ?>
            <div class="alert"><?php echo $_GET['Empty'] ?></div>
            <?php
        }

        ?>

        <?php
        if(@$_GET['Invalid'] == true)
        {
            ?>
            <div class="alert"><?php echo $_GET['Invalid'] ?></div>
            <?php
        }
        ?>

        <div class="textbox">
            <input type="text" placeholder="Email" id="email" name="email">
        </div>

        <div class="textbox">
            <input type="password" placeholder="Password" id="password" name="password">
        </div>

        <button class="btn" name="Login">Sign in</button>

        <did class="text">
            <p>Not a member ?<a href="register.php"> Sign Up</a></p>
        </did>
    </div>
</form>
</header>
</body>
</html>


