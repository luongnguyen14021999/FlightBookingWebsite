<!DOCTYPE html>
<head lang="en">
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
                background-image: url("flight2.jpeg");
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
                padding: 5px 10px;
                border: 1px solid transparent;
                transition: 0.6s ease;
                background-color: darkgray;
            }

            ul li a[id="customer"] {
                text-decoration: none;
                padding-left: 0;
                border: 1px solid transparent;
                transition: 0.6s ease;
                color: red;
            }

            ul li a[id="admin"] {
                text-decoration: none;
                padding-left: 0;
                border: 1px solid transparent;
                transition: 0.6s ease;
                color: red;
            }

            ul li a:hover {
                background-color: lightcoral;
                color: white;
            }

            .main {
                min-width: 1200px;
                margin: auto;
            }

            .title h1 {
                padding-top: 10%;
                font-family: font-family: 'Times New Roman', sans-serif;
                color: cornflowerblue;
                font-size: 450%;
                text-align: center;
            }

            .title h2 {
                font-family: font-family: 'Times New Roman', sans-serif;
                color: dodgerblue;
                font-size: 300%;
                text-align: center;
            }

            h3 {
                margin-left: 0%;
                padding: 0;
                color: blue;
                font-size: 30px;
            }

            h2 {
                margin-left: 10%;
                padding: 0;
                color: green;
                font-size: 20px;
            }

            p {
                margin-left: 0%;
                color: gray;
                font-size: 20px;
            }

            a {
                margin-left: 0%;
                color: red;
                font-size: 20px;
            }

            img {
                margin-left: 5px;
            }

            a[class="result"] {
                color: red;
            }

            .listOfFlights {
                width: 70%;
                height: 300px;
                border: 1px dotted red;
                overflow-y: scroll;
                margin-left: 10%;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="main">
        <?php
        session_start();
        require_once("dbconn.php");
        if(isset($_SESSION['email'])) {
            $user = $_SESSION['email'];
            $query = "select * from customer where email = '" . $user . "' and admin = 1 ";
            $query1 = "select * from customer where email = '" . $user . "' and admin = 0 ";
            $result = mysqli_query($dbConn, $query);
            $result1 = mysqli_query($dbConn, $query1);
            while ($row = $result->fetch_assoc()) {
                echo '<ul>
                    <li><a id="admin">' . $user . '</a></li>
                    <li><a href="index.php">Home</a></li>
                    <li><a id="flights" href= "flights.php">Flights</a></li>
                    <li><a id="logout" href= "logoff.php?logout">Sign out</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Download</a></li>
                </ul>';
            }

            while ($row = $result1->fetch_assoc()) {
                $customer_id = $row['id'];
                echo '<ul>
                    <li><a id="customer">' . $user . '</a></li>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="profile.php">My Profile</a></li>
                    <li><a href="newbooking.php">New Booking</a></li>
                    <li><a id="logout" href= "logoff.php?logout">Sign out</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Download</a></li>
                </ul>';
            }

            $queryFlight = "Select * from flight inner join booking on flight.id = booking.flight_id where customer_id='" . $customer_id . "'";
            $resultFlight = $dbConn->query($queryFlight);
            echo '<div class="title"><h1>' . "Wellcome to Vietnam Airlines" . '</h1><h2>' . "To Fly To Serve!" . '</h2></div>';
            echo '<h2>' . "Scroll down to observe all flights !" . '</h2>';
            $currentDate = new DateTime();
            $currentDate = $currentDate->format('Y-m-d H:i:s');
            $now = new DateTime();
            $now->modify('+2 day');
            $plusTwoDay = $now->format('Y-m-d H:i:s');
            echo '<div class="listOfFlights">';
            while ($row = $resultFlight->fetch_assoc()) {
                if($row['flight_datetime'] > $currentDate && $row['flight_datetime'] <= $plusTwoDay && $row['checkedin'] == 0) {
                    echo '<div class="listOfFlights">'
                        . '<h3>' . "Flight Number: " . $row['flight_number'] . '</h3>'
                        . '<p>' . "Flight Status: " . $row['status'] . '</p>'
                        . '<p>' . "Destination Airport: " . $row['to_airport'] . '</p>'
                        . '<p>' . "Date Booked: " . $row['booking_datetime'] . '</p>'
                        . '<p>' . "Flight Departure Time: " . $row['flight_datetime'] . '</p>'
                        . '<p>Checked in Status: Not yet</p>'
                        .'<p><a id="checkin" href="checkin.php?bookingDateTime='.$row['booking_datetime'].'" style="color: chartreuse">Checked in</a></p>'
                        . '</div></br>';
                } else if($row['flight_datetime'] > $currentDate && $row['flight_datetime'] <  $plusTwoDay && $row['checkedin'] == 1) {
                    echo '<div class="listOfFlights">'
                        . '<h3>' . "Flight Number: " . $row['flight_number'] . '</h3>'
                        . '<p>' . "Flight Status: " . $row['status'] . '</p>'
                        . '<p>' . "Destination Airport: " . $row['to_airport'] . '</p>'
                        . '<p>' . "Date Booked: " . $row['booking_datetime'] . '</p>'
                        . '<p>' . "Flight Departure Time: " . $row['flight_datetime'] . '</p>'
                        . '<p>Checked in Status: Already</p>'
                        . '</div></br>';
                } else if ($row['flight_datetime'] > $plusTwoDay) {
                    echo '<div class="listOfFlights">'
                        . '<h3>' . "Flight Number: " . $row['flight_number'] . '</h3>'
                        . '<p>' . "Flight Status: " . $row['status'] . '</p>'
                        . '<p>' . "Destination Airport: " . $row['to_airport'] . '</p>'
                        . '<p>' . "Date Booked: " . $row['booking_datetime'] . '</p>'
                        . '<p>' . "Flight Departure Time: " . $row['flight_datetime'] . '</p>'
                        . '<p>Checked in Status: Not yet</p>'
                        . '</div></br>';
                }
            }
            echo '</div>';
        }
        ?>
    </div>
</header>
</body>
</html>