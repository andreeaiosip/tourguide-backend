if ($procedure=="completebooking"){

$myBookingID = $_REQUEST["myBKID_in_php"];

$query = "SELECT *,booking.uid AS bookingID_fromDB
              FROM booking
              LEFT JOIN tours ON tours.uid = booking.touruid
              LEFT JOIN tourguide ON tourguide.uid = booking.tourguideuid
              WHERE booking.uid='".$myBookingID."'";
  $result = mysqli_query($dbConn, $query);
  while($Arrayline = mysqli_fetch_assoc($result)) {
      $myBookingRef 		= $Arrayline["bookref"];
      $myBookingPerson    = $Arrayline['customerFName']." ".$Arrayline['customerSName'];
      $myTourBooked       = $Arrayline["name"];
      $tourselect         = $Arrayline["touruid"];
      }


  echo "<H1>My Booking Reference: ".$myBookingRef."</H1>";
  echo "<H5>Booking Person: ".$myBookingPerson."</H5>";
  echo "<H5>Tour Booked: ".$myTourBooked."</H5>";

  echo '<a href="home.php?procedure=docompleted&myBKID_in_php='.$myBookingID.'">Confirm tour has been completed!</a>';
  echo '<br /><br /><a href="home.php?procedure=bookings">get me the heck of out here!</a>';



  }

if ($procedure=="docompleted"){

  $myBookingID = $_REQUEST["myBKID_in_php"];

  $mySQLUPD = "UPDATE booking SET completed=1, completeflaggedby='".$_SESSION["User_ID"]."' WHERE uid='".$myBookingID."'";
  $result = mysqli_query($dbConn, $mySQLUPD);

  echo '<meta http-equiv="refresh" content="0;url=home.php?procedure=bookings"/>';

}
