<?php

  $procedure = $_REQUEST["procedure"] ;

  include('myDBConnection.php');

// down below deck i called !
//Delete_A_record($dbConn,"tours",$tuid,"tours");

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
	echo '<body onload="myFunction()">';
}else {
	echo '<body>';
	}

 include('menuTabs.php');



if ($procedure=="bookings"){


echo '<table>
  <tr>
	<th>Book Ref</th>
	<th>Tour Date</th>
    <th>Customer Name & Surname</th>
    <th>Tour Name</th>
	<th>Pax</th>
	<th>Assigned Guide</th>
	<th>Done</th>
	<th>Action</th>
	
  </tr>';

	$query = "SELECT *
				FROM bookings
				LEFT JOIN tours ON tours.uid = bookings.tourUid ";
	$result = mysqli_query($dbConn, $query);
	while($Arrayline = mysqli_fetch_assoc($result)) {

		 echo '<tr>
			<td>'.$Arrayline['bookref'].'</td>
			<td>'.$Arrayline['dateTour'].'</td>
		    <td>'.$Arrayline['customerName']." ".$Arrayline['customerSurname'].'</td>
		    <td>'.$Arrayline['TourName'].'</td>
			<td>'.$Arrayline['Pax'].'</td>
			<td>'.$Arrayline['guideName'].'</td>
			<td>'.$Arrayline[''].'</td>
			<td>'.$Arrayline[''].'</td>
		  </tr>';



	}

  echo '</table>';



	}
 

if (isset($_REQUEST["showSnack"])){
	echo '<div id="snackbar">'.$_REQUEST["showSnack"].'</div>';
	}

?>


</body>




