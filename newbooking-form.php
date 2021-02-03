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
        $customer_id = $row['id'];
        echo '<ul>
                    <li><a id="customer">'.$user.'</a></li>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="newbooking.php">New Booking</a></li>
                    <li><a href="bookings.php">Bookings</a></li>
                    <li><a id="logout" href= "logoff.php?logout">Sign out</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Download</a></li>
                </ul>';
    }

    if(@$_GET['flightDateTime'] == true) {
        $flightDateTime = $_GET['flightDateTime'];
    }
    $query2 = "Select * from flight where flight_datetime = '".$flightDateTime."'";
    $result2 = mysqli_query($dbConn,$query2);
    while ($row=$result2->fetch_assoc()) {
        $flight_id = $row['id'];
        $flight_number = $row['flight_number'];
    }
    $booking_datetime = new DateTime();
    $booking_datetime = $booking_datetime->format('Y-m-d H:i:s');
}
?>
<?php
$cardNoMsg = "";
$cardNameMsg = "";
$expiryMsg = "";
if(isset($_POST['Booking'])) {

    if (empty($_POST['cardNo']) || empty($_POST['cardName']) || empty($_POST['expiry'])) {
        if(empty($_POST['cardNo'])) {
            $cardNoMsg = "<span class='errorMsg'>**Card number is required.</span>";
        }
        if(empty($_POST['cardName'])) {
            $cardNameMsg = "<span class='errorMsg'>**Card name is required.</span>";
        }
        if(empty($_POST['expiry'])) {
            $expiryMsg = "<span class='errorMsg'>**Card expiry is required.</span>";
        }
    }

    if (isset($_POST["cardNo"])) {
        $cardNo = $_POST['cardNo'];
    }
    if (isset($_POST["cardName"])) {
        $cardName = $_POST['cardName'];
    }
    if (isset($_POST['expiry'])) {
        $cardExpiry = $_POST['expiry'];
    }

    if(empty($cardNoMsg) && empty($cardNameMsg) && empty($expiryMsg)) {
        $sql = "INSERT INTO booking(customer_id,flight_id,booking_datetime) VALUES ('$customer_id','$flight_id','$booking_datetime')";
        if($dbConn->query($sql) === false) {
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
                background-image: url("flight4.jpeg");
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

            .bookingForm-box {
                width: 50%;
                height: 80%;
                position: absolute;
                top: 45%;
                left: 50%;
                transform: translate(-50%,-50%);
                text-align: center;
            }

            .bookingForm-box h1 {
                color: black;
                text-transform: uppercase;
                font-size: 400%;
                text-align: center;
                font-family: 'Raleway', sans-serif;
            }

            .bookingForm-box input[type="text"], .bookingForm-box input[type="password"], select[class="select"]{
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

            .bookingForm-box input[type="text"]:focus, .bookingForm-box input[type="password"]:focus {
                width: 80%;
                border-color: cornflowerblue;
            }

            .bookingForm-box button {
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

            .bookingForm-box button:hover {
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
    <form id="newbooking-form" action="newbooking-form.php?flightDateTime=<?php echo $flightDateTime ?>" method="post">
        <div class="bookingForm-box">

            <h1>Booking form</h1>

            <?php
            if(@$_GET['Empty'] == true)
            {
                ?>
                <div class="alert"><?php echo $_GET['Empty'] ?></div>
                <?php
            }
            ?>

            <div class="textbox">
                <input type="text" placeholder="Flight Number" id="flightNo" name="flightNo"  disabled value="<?php echo $flight_number; ?>">
            </div>

            <div class="textbox">
                <input type="text" placeholder="Standard fee" id="standardFee" name="standardFee"  disabled value="455$">
            </div>

            <div class="textbox">
                <input type="text" placeholder="Credit card number" id="cardNo" name="cardNo"  value="<?php echo htmlspecialchars($cardNo); ?>"><?php echo $cardNoMsg; ?>
            </div>

            <div class="textbox">
                <input type="text" placeholder="Credit card name" id="cardName" name="cardName" value="<?php echo htmlspecialchars($cardName); ?>"><?php echo $cardNameMsg; ?>
            </div>

            <div class="textbox">
                <input type="text" placeholder="Credit card expire" id="expiry" name="expiry" value="<?php echo htmlspecialchars($cardExpiry); ?>"><?php echo $expiryMsg; ?>
            </div>

            <button class="btn" name="Booking">Booking</button>
        </div>
</header>
</body>
</html>


