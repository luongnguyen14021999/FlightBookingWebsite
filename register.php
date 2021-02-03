<?php
session_start();
?>
<?php
$fName = "";
$lName = "";
$email = "";
$address = "";
$suburb = "";
$postCode = "";
$state = "";
$password = "";
$repeatPassword = "";
$phone = "";
$admin = "0";
$id = "";
require_once("dbconn.php");
if(isset($_POST['Register']))
{
    if(empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['email']) || empty($_POST['postcode']) || empty($_POST['state']) || empty($_POST['password']) || empty($_POST['repeatPassword']) || empty($_POST['suburb']) || empty($_POST['phone']) || empty($_POST['address']))
    {
        header("location: register.php?Empty= **Please fill in the spaces");
    } else {
        if (isset($_POST["firstName"])) {
            $fName = $_POST['firstName'];
            $check = "/^[A-Z][a-z][A-Za-z]*$/";
            if (!preg_match($check, $fName)) {
                $fNameMsg = "<span class='errorMsg'>**Invalid input. First name must start with a capital letter.</span>";
            }
        }
        if (isset($_POST["lastName"])) {
            $lName = $_POST['lastName'];
            $check = "/^[A-Z][a-z][A-Za-z]*$/";
            if (!preg_match($check, $lName)) {
                $lNameMsg = "<span class='errorMsg'>**Invalid input. Last name must start with a capital letter.</span>";
            }
        }
        if(isset($_POST['email'])) {
            $email = $_POST['email'];
            $sql = "Select email from customer where email = '".$email."'";
            $result = mysqli_query($dbConn,$sql);
            $row = mysqli_num_rows($result);
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $emailMsg = "<span class='errorMsg'>**Invalid email format.</span>";
            } else {
                if($row > 0) {
                    $emailMsg = '<span class="errorMsg">**This email is already exist. Please fill again</span>';
                }
            }
        }

        if(isset($_POST['postcode'])) {
            $postCode = $_POST['postcode'];
            $check = "/^\d{4}$/";
            if(!preg_match($check,$postCode)){
                $postCodeMsg = "<span class='errorMsg'>**Invalid postcode format.</span>";
            }
        }

        if(isset($_POST['state'])) {
            $state = $_POST['state'];
        }

        if(isset($_POST["address"])){
            $address = $_POST['address'];
            $check = "/^[A-Za-z-0-9- ']{1,20}$/";
            if(!preg_match($check,$address)){
                $addressMsg = "<span class='errorMsg'>**Invalid format. Maximum input is 20 characters</span>";
            }
        }

        if(isset($_POST["suburb"])){
            $suburb = $_POST['suburb'];
            $check = "/^[A-Za-z-']{1,20}$/";
            if(!preg_match($check,$suburb)){
                $suburbMsg = "<span class='errorMsg'>**Invalid format. Maximum 20 letters.</span>";
            }
        }

        if(isset($_POST["phone"])){
            $phone = $_POST['phone'];
            $check = "/^04[0-9]{8}$/";
            if(!preg_match($check,$phone)){
                $phonebMsg = "<span class='errorMsg'>**Invalid format. Must be 10 digits and begin with 04.</span>";
            }
        }

        if(isset($_POST["admin"])){
            $admin = $_POST["admin"];
        }


        if(isset($_POST['password'])) {
            $password = $_POST['password'];
            $passwordWithAlgorithm = hash("sha256", $password);
            $sql = "Select password from customer where password = '".$passwordWithAlgorithm."'";
            $result = mysqli_query($dbConn,$sql);
            $row = mysqli_num_rows($result);
            $check = "/^(?=.*?[0-9]).{8}$/";
            if(!preg_match($check,$password)){
                $passwordMsg = "<span class='errorMsg'>**Invalid password format.</span>";
            } else {
                if($row > 0) {
                    $passwordMsg = '<span class="errorMsg">**This password is already exist. Please fill again</span>';
                }
            }
        }

        if(isset($_POST['repeatPassword'])) {
            $repeatPassword = $_POST['repeatPassword'];
            if($repeatPassword != $password) {
                $repeatPasswordMsg = "<span class='errorMsg'>**Password does not match.</span>";
            }
        }
    }

    if(empty($fNameMsg) && empty($lNameMsg) && empty($emailMsg) && empty($passwordMsg) && empty($repeatPasswordMsg) && empty($addressMsg) && empty($suburbMsg) && !empty($state) && empty($postCodeMsg) && empty($phonebMsg)) {
        $sql = "INSERT INTO customer(fname,lname,email,password,address,suburb,state,postcode,phone,admin) VALUES ('$fName','$lName','$email','$password','$address', '$suburb', '$state', '$postCode', '$phone', '$admin')";
        if($dbConn->query($sql) === true) {
            echo 'Successfully Added a New Record to the Customer Table';
        } else{
            echo "Failed to insert new record";
            echo "Error: " . $sql . "<br>" . $dbConn->error;
        }
    }

    $dbConn->close();
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
            background-image: url("flight3.jpeg");
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

        .register-box {
            width: 50%;
            height: 80%;
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%,-50%);
            text-align: center;
        }

        .register-box h1 {
            color: black;
            text-transform: uppercase;
            font-size: 400%;
            text-align: center;
            font-family: 'Raleway', sans-serif;
        }

        .register-box input[type="text"], .register-box input[type="password"], select[class="select"]{
            border: 0;
            display: block;
            margin: 3% auto;
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

        span[class="errorMsg"] {
            color: red;
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
            color: green;
        }

        .register-box input[type="text"]:focus, .register-box input[type="password"]:focus {
            width: 80%;
            border-color: cornflowerblue;
        }

        .register-box button {
            border: 0;
            display: block;
            margin: 4% auto;
            text-align: center;
            border: 2px solid cornflowerblue;
            color: black;
            border-radius: 24px;
            transition: 0.25s;
            height: 40px;
            width: 20%;
            font-size: 30px;
        }

        .register-box button:hover {
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
<div class="mainRegister">

    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Sign In</a></li>
        <li><a href="#">Help</a></li>
        <li><a href="#">Download</a></li>
    </ul>
</div>
<form id="register" action="register.php" method="post">
    <div class="register-box">

        <h1>Register</h1>

        <?php
        if(@$_GET['Empty'] == true)
        {
            ?>
            <div class="alert"><?php echo $_GET['Empty'] ?></div>
            <?php
        }

        ?>

        <div class="textbox">
            <input type="text" placeholder="First name" id="firstName" name="firstName" value="<?php echo htmlspecialchars($fName); ?>"><?php echo $fNameMsg; ?>
        </div>

        <div class="textbox">
            <input type="text" placeholder="Last name" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lName); ?>"><?php echo $lNameMsg; ?>
        </div>

        <div class="textbox">
            <input type="text" placeholder="Email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><?php echo $emailMsg; ?>
        </div>

        <div class="textbox">
            <input type="password" placeholder="Password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>"><?php echo $passwordMsg; ?>
        </div>

        <div class="textbox">
            <input type="password" placeholder="Repeat password" id="repeatPassword" name="repeatPassword" value="<?php echo htmlspecialchars($repeatPassword); ?>"><?php echo $repeatPasswordMsg; ?>
        </div>

        <div class="textbox">
            <input type="text" placeholder="Address" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>"><?php echo $addressMsg; ?>
        </div>

        <div class="textbox">
            <input type="text" placeholder="suburb" id="suburb" name="suburb" value="<?php echo htmlspecialchars($suburb); ?>"><?php echo $suburbMsg; ?>
        </div>

        <select class="select" name="state" id="state" >
            <option value=""  selected disabled>Select State</option>
            <option value="NSW" <?php if (!empty($state) && $state == 'NSW' ) echo "selected = 'selected'"; ?>>NSW</option>
            <option value="QLD" <?php if (!empty($state) && $state == 'QLD' ) echo "selected = 'selected'"; ?>>QLD</option>
            <option value="VIC" <?php if (!empty($state) && $state == 'VIC' ) echo "selected = 'selected'"; ?>>VIC</option>
            <option value="TAS" <?php if (!empty($state) && $state == 'TAS' ) echo "selected = 'selected'"; ?>>TAS</option>
            <option value="NT" <?php if (!empty($state) && $state == 'NT' ) echo "selected = 'selected'"; ?>>NT</option>
            <option value="WA" <?php if (!empty($state) && $state == 'WA' ) echo "selected = 'selected'"; ?>>WA</option>
            <option value="SA" <?php if (!empty($state) && $state == 'SA' ) echo "selected = 'selected'"; ?>>SA</option>
        </select>

        <div class="textbox">
            <input type="text" placeholder="Postcode" id="postcode" name="postcode" value="<?php echo htmlspecialchars($postCode); ?>"><?php echo $postCodeMsg; ?>
        </div>

        <div class="textbox">
            <input type="text" placeholder="phone" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>"><?php echo $phonebMsg; ?>
        </div>

        <select class="select" name="admin" id="admin" >
            <option value="0"  selected disabled>Customer</option>
            <option value="0" <?php if (!empty($admin) && $admin == '0' ) echo "selected = 'selected'"; ?>>Customer</option>
            <option value="1" <?php if (!empty($admin) && $admin == '1' ) echo "selected = 'selected'"; ?>>Admin</option>
        </select>

        <did class="text">
            <p>Already a member ?<a href="login.php">Sign In</a></p>
        </did>

        <button class="btn" name="Register">Register</button>
    </div>
</form>
</header>
</body>
</html>



