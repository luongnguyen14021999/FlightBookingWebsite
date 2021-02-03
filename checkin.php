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

    if(@$_GET['bookingDateTime'] == true) {
        $bookingDateTime = $_GET['bookingDateTime'];
    }
    $query2 = "Select * from booking inner join flight on booking.flight_id = flight.id where booking_datetime = '".$bookingDateTime."'";
    $result2 = mysqli_query($dbConn,$query2);
    while ($row=$result2->fetch_assoc()) {
        $flight_id = $row['id'];
        $flight_number = $row['flight_number'];
    }
    $query3 = "Select * from flight inner join plane on flight.plane = plane.id where flight.id = '".$flight_id."'";
    $result3 = mysqli_query($dbConn,$query3);
    while ($row3=$result3->fetch_assoc()) {
        $max_baggage_weight = $row3['max_baggage_weight'];
        $seating = $row3['seating'];
    }
    $maximumPerSeating = $max_baggage_weight/$seating;
}
?>
<?php
$baggageMsg = "";
if(isset($_POST['Checkin'])) {
    if (empty($_POST['customerBaggage'])) {
            $baggageMsg = "<span class='errorMsg'>**Your baggage is required.</span>";
    }

    if (isset($_POST["customerBaggage"])) {
        $customerBaggage = $_POST['customerBaggage'];
    }
    if($customerBaggage > $maximumPerSeating) {
        $baggageMsg = "<span class='errorMsg'>**Your baggage is over allowable baggage weight.</span>";
    } else {
        $checkInDateTime = new DateTime();
        $checkInDateTime = $checkInDateTime->format('Y-m-d H:i:s');
        $sql = "UPDATE booking SET checkedin='1', checkin_datetime = '$checkInDateTime', baggage='$customerBaggage' WHERE booking_datetime ='$bookingDateTime'";
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
        <form id="checkin" action="checkin.php?bookingDateTime=<?php echo $bookingDateTime ?>" method="post">
            <div class="bookingForm-box">

                <h1>Form Check In</h1>

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
                    <input type="text" placeholder="baggage" id="allowableBaggage" name="allowableBaggage"  disabled value="<?php echo $maximumPerSeating." kg is maximum"; ?>">
                </div>

                <div class="textbox">
                    <input type="text" placeholder="Your Baggage Weight(kg)" id="customerBaggage" name="customerBaggage" value="<?php echo htmlspecialchars($customerBaggage); ?>"><?php echo $baggageMsg; ?>
                </div>

                <button class="btn" name="Checkin">Check in</button>
            </div>
</header>
</body>
</html>



