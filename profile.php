<?php
session_start();
?>
<?php
require_once("dbconn.php");
if(isset($_SESSION['email'])) {
    $user = $_SESSION['email'];
    $query1 = "select * from customer where email = '".$user."' and admin = 0 ";
    $result1 = mysqli_query($dbConn,$query1);

    while ($row=$result1->fetch_assoc())
    {
        echo '<ul>
                    <li><a id="customer">'.$user.'</a></li>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="newbooking.php">New Booking</a></li>
                    <li><a href="bookings.php">Bookings</a></li>
                    <li><a id="logout" href= "logoff.php?logout">Sign out</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Download</a></li>
                </ul>';
        $id = $row['id'];
        $fName =$row['fname'];
        $lName = $row['lname'];
        $email = $row['email'];
        $address = $row['address'];
        $suburb = $row['suburb'];
        $postCode = $row['postcode'];
        $state = $row['state'];
        $phone = $row['phone'];
    }
}
?>
<?php
$fNameMsg = "";
$lNameMsg = "";
$addressMsg = "";
$suburbMsg = "";
$postCodeMsg = "";
$phoneMsg = "";
require_once("dbconn.php");
if(isset($_POST['Profile'])) {
    if (isset($_POST["firstName"])) {
        $fName = $_POST['firstName'];
    }
    if (isset($_POST["lastName"])) {
        $lName = $_POST['lastName'];
    }
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }

    if (isset($_POST['postcode'])) {
        $postCode = $_POST['postcode'];
    }

    if (isset($_POST['state'])) {
        $state = $_POST['state'];
    }

    if (isset($_POST["address"])) {
        $address = $_POST['address'];
    }

    if (isset($_POST["suburb"])) {
        $suburb = $_POST['suburb'];
    }

    if (isset($_POST["phone"])) {
        $phone = $_POST['phone'];
    }

    if(empty($fName)) {
        $fNameMsg = "<span class='errorMsg'> First name is required.</span>";
    } else {
        $check = "/^[A-Z][a-z][A-Za-z]*$/";
        if (!preg_match($check, $fName)) {
            $fNameMsg = "<span class='errorMsg'>**Invalid input. First name must start with a capital letter.</span>";
        }
    }

    if(empty($lName)) {
        $lNameMsg = "<span class='errorMsg'> Last name is required.</span>";
    } else {
        $check1 = "/^[A-Z][a-z][A-Za-z]*$/";
        if (!preg_match($check1, $lName)) {
            $lNameMsg = "<span class='errorMsg'>**Invalid input. Last name must start with a capital letter.</span>";
        }
    }

    if(empty($email)) {
        $emailMsg = "<span class='errorMsg'> Email is required.</span>";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailMsg = "<span class='errorMsg'>**Invalid email format.</span>";
        }
    }

    if(empty($postCode)) {
        $postCodeMsg = "<span class='errorMsg'> Postcode is required.</span>";
    } else {
        $check2 = "/^\d{4}$/";
        if (!preg_match($check2, $postCode)) {
            $postCodeMsg = "<span class='errorMsg'>**Invalid postcode format.</span>";
        }
    }

    if(empty($address)) {
        $addressMsg = "<span class='errorMsg'> Address is required.</span>";
    } else {
        $check4 = "/^[A-Za-z-0-9- ']{1,20}$/";
        if (!preg_match($check4, $address)) {
            $addressMsg = "<span class='errorMsg'>**Invalid format. Maximum 20 letters.</span>";
        }
    }

    if(empty($suburb)) {
        $suburbMsg = "<span class='errorMsg'> Suburb is required.</span>";
    } else {
        $check3 = "/^[A-Za-z-0-9- ']{1,20}$/";
        if (!preg_match($check3, $suburb)) {
            $suburbMsg = "<span class='errorMsg'>**Invalid format. Maximum input is 20 characters</span>";
        }
    }

    if (empty($phone)) {
        $phoneMsg = "<span class='errorMsg'> Phone is required.</span>";
    } else {
        $check5 = "/^04[0-9]{8}$/";
        if (!preg_match($check5, $phone)) {
            $phoneMsg = "<span class='errorMsg'>**Invalid format. Must be 10 digits and begin with 04.</span>";
        }
    }

    if(empty($fNameMsg) && empty($lNameMsg) && empty($emailMsg)  && empty($addressMsg) && empty($suburbMsg)  && empty($postCodeMsg) && empty($phoneMsg)) {
        $sql = "UPDATE customer SET fname='$fName', lname = '$lName', email='$email', address = '$address', state = '$state', postcode = '$postCode', phone ='$phone', suburb = '$suburb' WHERE id='$id'";

        if ($dbConn->query($sql) === FALSE) {
            echo "Error updating record: " . $dbConn->error;
        }
    }
    $dbConn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
    <title>Book Flight Application</title>
    <style>
        @media screen and (min-width:1200px) {

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

            .profile-box {
                width: 50%;
                height: 80%;
                position: absolute;
                top: 45%;
                left: 50%;
                transform: translate(-50%,-50%);
                text-align: center;
            }

            .profile-box h1 {
                color: black;
                text-transform: uppercase;
                font-size: 400%;
                text-align: center;
                font-family: 'Raleway', sans-serif;
            }

            .profile-box input[type="text"], .profile-box input[type="password"], select[class="select"]{
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

            .profile-box input[type="text"]:focus, .profile-box input[type="password"]:focus {
                width: 80%;
                border-color: cornflowerblue;
            }

            .profile-box button {
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
                font-size: 20px;
            }

            .profile-box button:hover {
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
    <div class="main">
        <form id="profile" action="profile.php" method="post">
            <div class="profile-box">

                <h1>Profile</h1>

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
                    <input type="text" placeholder="Email" id="email" name="email" disabled value="<?php echo htmlspecialchars($email); ?>">
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
                    <input type="text" placeholder="phone" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>"><?php echo $phoneMsg; ?>
                </div>

                <button class="btn" name="Profile">Save Profile</button>
            </div>
        </form>
</header>
</body>
</html>


