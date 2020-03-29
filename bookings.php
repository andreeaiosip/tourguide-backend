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
<style>
 body {font-family: Arial, Helvetica, sans-serif;}
 
 .navbar {
   width: 100%;
   background-color: #555;
   overflow: auto;
 }
 
 .navbar a {
   float: left;
   padding: 12px;
   color: white;
   text-decoration: none;
   font-size: 17px;
 }
 
 .navbar a:hover {
   background-color: #000;
 }
 
 .active {
   background-color: #4CAF50;
 }
 
 .about-section {
   padding: 50px;
   text-align: center;
   background-color: #474e5d;
   color: white;
 }
 
 @media screen and (max-width: 500px) {
   .navbar a {
	 float: none;
	 display: block;
   }
 }
 
 table {
   border-collapse: collapse;
   border-spacing: 0;
   width: 100%;
   border: 1px solid #ddd;
 }
 
 th, td {
   text-align: left;
   padding: 16px;
 }
 
 tr:nth-child(even) {
   background-color: #f2f2f2;
 }
 
 </style>


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
    <th>Customer name & Surname</th>
    <th>Tour booked</th>
    <th>No of People</th>
  </tr>';

	$query = "SELECT *
				FROM bookings
				LEFT JOIN tours ON tours.uid = bookings.touruid ";
	$result = mysqli_query($dbConn, $query);
	while($Arrayline = mysqli_fetch_assoc($result)) {

		 echo '<tr>
		    <td>'.$Arrayline['bookref'].'</td>
		    <td>'.$Arrayline['customerFName']." ".$Arrayline['customerSName'].'</td>
		    <td>'.$Arrayline['description'].'</td>
		    <td>'.$Arrayline['people'].'</td>
		  </tr>';



	}

  echo '</table>';



	}
 

if (isset($_REQUEST["showSnack"])){
	echo '<div id="snackbar">'.$_REQUEST["showSnack"].'</div>';
	}

?>


</body>




