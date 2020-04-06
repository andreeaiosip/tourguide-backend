<?php

if ($procedure=="assign_a_booking"){


$myBookingID = $_REQUEST["myBKID_in_php"];


$query = "SELECT * bookings.guid AS bookingsDB
				FROM bookings
				LEFT JOIN tours ON tours.uid = bookings.tourUid
				LEFT JOIN tourGuide ON tourGuide.uid = bookings.tourGuideUid
				WHERE bookings.guid='".$myBookingID."'";
	$result = mysqli_query($dbConn, $query);
	while($Arrayline = mysqli_fetch_assoc($result)) {
		$myBookingRef 		= $Arrayline["bookref"];
        $myCustomer    = $Arrayline['customerName']." ".$Arrayline['customerSurname'];
        $myTourBooked       = $Arrayline["tourName"];
        $tourselect         = $Arrayline["tourUid"];
		}


echo "<H1>My Booking Reference: ".$myBookingRef."</H1>";
echo "<H5>Booking Person: ".$myCustomer."</H5>";
echo "<H5>Tour Booked: ".$myTourBooked."</H5>";

$tourguide   = $_REQUEST["tourGuide"];
$wasiposted  = $_REQUEST["wasiposted"];

if ($wasiposted <>""){

	$tourselect = $_REQUEST["tourselect"];

	$mySQLUPD = "UPDATE bookings SET tourGuideUid='".$tourguide."',tourUid='".$tourselect."' WHERE guid='".$myBookingID."'";
    $result = mysqli_query($dbConn, $mySQLUPD);

    echo "Record Updated successfully...";

	echo '<meta http-equiv="refresh" content="0;url=bookings.php?procedure=bookings&showSnack=Booking Updated successfully..." />';


 // update the booking Table with the Tour guide ID
	}else{


   }

echo '
  <form action="home.php?procedure='.$procedure.'&myBKID_in_php='.$myBookingID.'" method="post">
  <label for="tourguide">Tour guide:</label><br>';

	echo '<SELECT name="tourGuide">';
	echo "<OPTION value='NONE'>NONE SELECTED</OPTION>\n";

	$query = "SELECT * FROM tourGuide WHERE active=1";
	$result = mysqli_query($dbConn, $query);
	while($Arrayline = mysqli_fetch_assoc($result)) {

		echo "<OPTION value='".$Arrayline["uid"]."'";
		// uid is from the DB!
		if ($tourguide == $Arrayline["uid"] ) {echo " SELECTED"; }
		echo ">".$Arrayline["firstName"] ."</OPTION>\n";

		}

    echo "</SELECT><br>";

    // the second part of the screen where i can select the new TOUR if they want to change!
  echo '<label for="tourselect">update Tour :</label><br>';

	echo '<SELECT name="tourselect">';
	echo "<OPTION value='NONE'>NONE SELECTED</OPTION>\n";

	$query = "SELECT * FROM tours";
	$result = mysqli_query($dbConn, $query);
	while($Arrayline = mysqli_fetch_assoc($result)) {

		echo "<OPTION value='".$Arrayline["uid"]."'";
		// uid is from the DB!
		if ($tourselect == $Arrayline["uid"] ) {echo " SELECTED"; }
		echo ">".$Arrayline["tourName"] ."</OPTION>\n";

		}

    echo "</SELECT><br>";


echo '
  <input type="hidden" name="wasiposted" value="formposted">
  <input type="submit" value="Submit">
  </form>';


	}
	
	
	?>