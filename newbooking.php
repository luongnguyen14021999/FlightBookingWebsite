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
            $query = "select * from customer where email = '".$user."' and admin = 1 ";
            $query1 = "select * from customer where email = '".$user."' and admin = 0 ";
            $result = mysqli_query($dbConn,$query);
            $result1 = mysqli_query($dbConn,$query1);
            while ($row=$result->fetch_assoc())
            {
                echo '<ul>
                    <li><a id="admin">'.$user.'</a></li>
                    <li><a href="index.php">Home</a></li>
                    <li><a id="flights" href= "flights.php">Flights</a></li>
                    <li><a id="logout" href= "logoff.php?logout">Sign out</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Download</a></li>
                </ul>';
            }

            while ($row=$result1->fetch_assoc())
            {
                echo '<ul>
                    <li><a id="customer">'.$user.'</a></li>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="profile.php">My Profile</a></li>
                    <li><a href="bookings.php">Bookings</a></li>
                    <li><a id="logout" href= "logoff.php?logout">Sign out</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Download</a></li>
                </ul>';
            }

            $queryFlight = "Select flight.id,flight_number,from_airport,to_airport,flight_datetime,plane,name,seating,max_baggage_weight from flight inner join plane on flight.plane = plane.id";
            $resultFlight = $dbConn->query($queryFlight);
            echo '<div class="title"><h1>' . "Wellcome to Vietnam Airlines" . '</h1><h2>' ."To Fly To Serve!" . '</h2></div>';
            echo '<h2>' . "Scroll down to observe all flights !" . '</h2>';
            echo '<div class="listOfFlights">';
            $currentDate = new DateTime();
            $currentDate = $currentDate->format('Y-m-d H:i:s');
            $now = new DateTime();
            $now->modify('+1 day');
            $plusOneDay = $now->format('Y-m-d H:i:s');
            while ($row = $resultFlight->fetch_assoc()) {
                $query = "Select flight_id from booking where flight_id = '" . $row['id'] ."'";
                $results0 = $dbConn->query($query);
                $numberOfSeat = 0;
                while($row0 = $results0->fetch_assoc()) {
                    $numberOfSeat++;
                }
                $query1 = "Select seating from plane where plane.id = '".$row['plane']."'";
                $results1 = $dbConn->query($query1);
                while($row1 = $results1->fetch_assoc()) {
                    $maximumSeats = $row1['seating'];
                }
                $seatsLeft = $maximumSeats - $numberOfSeat;
                if($seatsLeft == 0) {
                    if($row['flight_datetime'] > $currentDate && $row['flight_datetime'] < $plusOneDay) {
                        echo '<div class="listOfFlights">'
                            .'<h3>'."Flight: ". $row['flight_number'] .  '</h3>'
                            .'<p>'.$row['from_airport'] ." -> ". $row['to_airport']. " (".$row['distance_km']. ") - ".$row['name'].'</p>'
                            .'<p>'.$row['flight_datetime'].'</p>'
                            .'<p>'."Status: Open".'<img class="image" src="open.svg" width="20" height="20">'.'</p>'
                            .'<p>'."Seating: Full".'</p>'
                            .'</div></br>';
                    } else if($row['flight_datetime'] > $currentDate && $row['flight_datetime'] > $plusOneDay) {
                        echo '<div class="listOfFlights">'
                            .'<h3>'."Flight: ". $row['flight_number'] .  '</h3>'
                            .'<p>'.$row['from_airport'] ." -> ". $row['to_airport']. " (".$row['distance_km']. ") - ".$row['name'].'</p>'
                            .'<p>'.$row['flight_datetime'].'</p>'
                            .'<p>'."Status: Staged".'<img class="image" src="staged.svg" width="20" height="20">'.'</p>'
                            .'<p>'."Seating: Full".'</p>'
                            .'</div></br>';
                    }
                } else {
                     if($row['flight_datetime'] > $currentDate && $row['flight_datetime'] < $plusOneDay) {
                        echo '<div class="listOfFlights">'
                            .'<h3>'."Flight: ". $row['flight_number'] .  '</h3>'
                            .'<p>'.$row['from_airport'] ." -> ". $row['to_airport']. " (".$row['distance_km']. ") - ".$row['name'].'</p>'
                            .'<p>'.$row['flight_datetime'].'</p>'
                            .'<p>'."Status: Open".'<img class="image" src="open.svg" width="20" height="20">'.'</p>'
                            .'<p>'."Seating: ".$seatsLeft." seats left".'</p>'
                            .'<a href="newbooking-form.php?flightDateTime='.$row['flight_datetime'].'">Booking</a>'
                            .'</div></br>';
                    } else  if($row['flight_datetime'] > $currentDate && $row['flight_datetime'] > $plusOneDay) {
                        echo '<div class="listOfFlights">'
                            .'<h3>'."Flight: ". $row['flight_number'] .  '</h3>'
                            .'<p>'.$row['from_airport'] ." -> ". $row['to_airport']. " (".$row['distance_km']. ") - ".$row['name'].'</p>'
                            .'<p>'.$row['flight_datetime'].'</p>'
                            .'<p>'."Status: Staged".'<img class="image" src="staged.svg" width="20" height="20">'.'</p>'
                            .'<p>'."Seating: ".$seatsLeft." seats left".'</p>'
                            .'<a href="newbooking-form.php?flightDateTime='.$row['flight_datetime'].'">Booking</a>'
                            .'</div></br>';
                    }
                }
            }
            echo '</div>';
        }
        ?>
    </div>
</header>
</body>
</html>


