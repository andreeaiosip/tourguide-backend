<?php

session_start();

$show 		 = $_REQUEST["show"];
$mySQLFilter = "";
$bguid 		 = $_REQUEST["bguid"];
$procedure   = $_REQUEST["procedure"] ;


  include('myDBConnection.php');
  include('deleteFunction.php');
  include('commonFunctions.php');
 
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/css/style.css">


<script>
function myFunction() {
  var x = document.getElementById("snackbar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
</script>




<?php


if (isset($_REQUEST["showSnack"])){
	echo '<body class="body-height" onload="myFunction()">';
}else {
	echo '<body class="body-height">';
	}

 include('menuTabs.php');


// SHOW BOOKINGS ON THE PAGE ----------------
if ($procedure=="bookings"){


echo '<table >
  <tr>
    <th>Book ID</th>
	<th>Book Ref</th>
	<th>Tour Date</th>
    <th>Customer Name & Surname</th>
    <th>Tour Booked</th>
	<th>Pax</th>
	<th>Assigned Guide</th>
	<th>Completed</th>
	<th>Action</th>
	
  </tr>';

	$query = "SELECT *,bookings.guid AS bguid
				FROM bookings
				LEFT JOIN tours ON tours.uid = bookings.tourUid 
				LEFT JOIN tourGuide ON tourGuide.uid =  bookings.tourGuideUid";
	$result = mysqli_query($dbConn, $query);
	while($Arrayline = mysqli_fetch_assoc($result)) {

		 echo '<tr>
		    <td>'.$Arrayline['tourUid'].'</td>
		    <td>'.$Arrayline['bookref'].'</td>
			<td>'.$Arrayline['dateTour'].'</td>
		    <td>'.$Arrayline['customerName']." ".$Arrayline['customerSurname'].'</td>
		    <td>'.$Arrayline['TourName'].'</td>
			<td>'.$Arrayline['Pax'].'</td>
			<td>'.$Arrayline['guideName'].'</td>';
			if ($Arrayline['completed']=="0"){
				echo '<td><i style="color: #323232bf" class="fa fa-dot-circle-o fa-2x" aria-hidden="true"></i></td>';
			}else {
				echo '<td> <i style="color: #323232bf" class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i></td>';
				}
			
			

			echo '<td>';
		    echo '<a href="bookings.php?procedure=deleteBooking&bguid='.$Arrayline['bguid'].'" title="Delete Booking"><i style="color: #323232bf" class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
		    echo '<a href="bookings.php?procedure=isComplete&bguid='.$Arrayline['bguid'].'" title="Assign a tour guide"><i style="color:#323232bf" class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
		    echo '</td>';
		  echo '</tr>';

	}

  echo '</table>';


	}
 

	if ($procedure=="isComplete"){


	
	echo $bguid;



	}

	if ($procedure=="deleteBooking"){

		$bookingGuid = $_REQUEST["bguid"];

			$query    = "DELETE FROM bookings WHERE guid='".$bookingGuid."'";
			$result   = mysqli_query($dbConn, $query);
			echo '<meta http-equiv="refresh" content="0;url=bookings.php?procedure=bookings&showSnack=Record Deleted! successfully..." />';

		}

if (isset($_REQUEST["showSnack"])){
	echo '<div id="snackbar">'.$_REQUEST["showSnack"].'</div>';
	}


	//include('assignBooking.php');

?>


</body>




