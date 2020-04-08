<?php


session_start();


 $procedure = $_REQUEST["procedure"] ;


if ($_SESSION["User_ID"]==""){

	echo '<meta http-equiv="refresh" content="0;url=index.php?reason=notloggedin" />';

 }


if ($procedure=="bookings"){

//
echo  ' <a href="bookings.php?procedure=bookings&show=allmine"><button class="btn success" >Show my bookings</button></a>';
echo  ' <a href="bookings.php?procedure=bookings&show=all"><button class="btn success" >All Bookings</button></a>';
echo  ' <a href="bookings.php?procedure=bookings&show=new"><button class="btn success" >New Bookings</button></a>';
echo  ' <a href="bookings.php?procedure=bookings&show=done"><button class="btn success" >Completed Bookings</button></a>';


$show = $_REQUEST["show"];

$mySQLFilter = "";

if ($show=="done"){
	$mySQLFilter = " AND completed=1";
	}

if ($show=="new"){
	$mySQLFilter = " AND completed=0";
	}

if ($show=="" && $_SESSION["accessRole"] == "TG"){
	$mySQLFilter = " AND bookings.tourGuideUid='".$_SESSION["TG_uid"]."'";
	}

if ($show=="allmine"){
	$mySQLFilter = " AND bookings.tourGuideUid='".$_SESSION["TG_uid"]."'";
	}


echo '<table>
  <tr>
    <th>Book Ref</th>
    <th>Dated</th>
    <th>Customer name & Surname</th>
    <th>Email</th>
    <th>Tour Booked</th>
    <th>Pax</th>
    <th>Assigned Guide</th>
    <th>Done</th>
    <th>Action</th>
  </tr>';
/*echo'  <tr>
    <th><input name="Name" type="text" value=""></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
  </tr>';
*/


	$query = "SELECT *,bookings.guid AS myBookings
				FROM bookings
				LEFT JOIN tours ON tours.uid = bookings.tourUid
				LEFT JOIN tourGuide ON tourguide.uid = bookings.tourGuideUid
				WHERE 1=1
				".$mySQLFilter."
				ORDER BY dateTour DESC";
	$result = mysqli_query($dbConn, $query);

	// show for debugging reasons!!! when this dont look like they are working!
	//echo  $query;

	$result = mysqli_query($dbConn, $query);
	$myNumberofrecs = 0;
	while($Arrayline = mysqli_fetch_assoc($result)) {

		 $myNumberofrecs++;
		 echo '<tr>';
//		 echo '   <td>'.$Arrayline['bookref'];
		 if ($Arrayline['completed'] > 0 ) {
			 echo '<td bgcolor="yellow" >'.$Arrayline['bookref'].'</td>';
		 }else {
			 echo '<td>'.$Arrayline['bookref'].'</td>';

		 	}

		 echo '   </td>';
		 echo '   <td>'.$Arrayline['dateTour'].'</td>';
		 echo '   <td>'.$Arrayline['customerName']." ".$Arrayline['customerSurname'].'</td>';
		 echo '   <td>'.$Arrayline['customerEmail'].'</td>';
		 echo '   <td>'.$Arrayline['Description'].'</td>';
		 echo '   <td>'.$Arrayline['Pax'].'</td>';
		 echo '   <td>'.$Arrayline['guideName'].'</td>';

		 if ($Arrayline['completed'] > 0 ) {
		    echo '   <td><i class="fa fa-check" aria-hidden="true"></i></td>';
		    }else {
		    echo '   <td>&nbsp;</td>';
		    	  }

		 echo '   <td>';
		if ($Arrayline['completed'] == 0 ) {
	   		  echo '	<a href="home.php?procedure=assign_a_booking&myBKID_in_php='.$Arrayline['myBookings'].'" title="Assign a booking to a tour guide"><i class="fa fa-shopping-basket fa-lg" aria-hidden="true"></i></i></a>';
	   		  // when i can login in as a Tour Guide!
	   		  //echo '	<a href="home.php?procedure=takebooking&buid='.$Arrayline['BUID'].'" title="This will delete me"><i class="fa fa-shopping-basket fa-lg" aria-hidden="true"></i></i></a>';
			if ($Arrayline['firstName'] <> "" &&  $_SESSION["TG_uid"] == $Arrayline['tourGuideUid']) {
				  echo '	<a href="home.php?procedure=completebooking&myBKID_in_php='.$Arrayline['myBookings'].'" title="Flag as completed!!!"><i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i></a>';
		      }

			if ($_SESSION["AccessRole"] == "Admin"){
		 		echo '	<a href="bookings.php?procedure=cancelthisbooking&buid='.$Arrayline['myBookings'].'" title="This will delete me"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>';
	 		}
		  }

		 echo '   </td>';
		 echo ' </tr>';

	}

	echo'  <tr>
    <th></th>
    <th></th>
    <th>Tours : '.$myNumberofrecs.'</th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
  </tr>';


  echo '</table>';
?>

<?php
session_start();

$procedure = $_REQUEST["procedure"];
include('myDBConnection.php');
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
include('menuTabs.php');

if (isset($_REQUEST["showSnack"])){
	echo '<body onload="myFunction()">';
}else {
	echo '<body>';
	}


if ($_SESSION["AccessRole"]=="Adm"){
	echo  ' <a href="payroll.php?procedure=genpayroll"><button class="btn success" >Generate Payroll (Admin Side)</button></a>';
}else {
	echo  ' <a href="payroll.php?procedure=showmypay"><button class="btn success" >Calculate Pay (Tour Guide Side)</button></a>';
}
//echo  ' <button class="btn success" ></button>';


if (isset($_REQUEST["showSnack"])){
	echo '<div id="snackbar">'.$_REQUEST["showSnack"].'</div>';
 }



if ($procedure=="genpayroll"){



echo '<br /><br /><br /><br />
  <form action="payroll.php?procedure=genpayrollView" method="post">
  <label for="fromDate">Start Payroll Date:(Inclusive)</label><br>
  <input type="date" id="fromDate" name="fromDate" required value="'.$fromDate.'"><br>
  <label for="lname">End Payroll Date:(Inclusive)</label><br>
  <input type="date" id="EndDate" size="150" name="EndDate" required value="'.$EndDate.'"><br><br>
  <label for="tourguide">Tour guide:</label><br>';
	echo '<SELECT name="tourguide" required>';
	echo "<OPTION value='NONE'>NONE SELECTED</OPTION>\n";

	$query = "SELECT * FROM tourGuide ORDER BY guideName";
	$result = mysqli_query($dbConn, $query);
	while($Arrayline = mysqli_fetch_assoc($result)) {

		echo "<OPTION value='".$Arrayline["uid"]."'";
		// uid is from the DB!
		if ($tourguide == $Arrayline["uid"] ) {echo " SELECTED"; }
		echo ">".$Arrayline["guideName"] ."</OPTION>\n";

		}

    echo "</SELECT><br>";



echo '
  <input type="hidden" name="wasiposted" value="formposted">
  <input type="submit" value="Submit">
  </form>';






	}



if ($procedure=="genpayrollView"){

$tourguide = $_REQUEST["tourGuide"];
$EndDate   = $_REQUEST["EndDate"];
$fromDate  = $_REQUEST["fromDate"];

	$query = "SELECT *
				FROM tourGuide
	            LEFT JOIN commLevel ON commLevel.uid = tourGuide.commLevel
				WHERE tourGuide.uid='".$tourguide."'";
	$result = mysqli_query($dbConn, $query);
	while($Arrayline = mysqli_fetch_assoc($result)) {
		$myGuideName   = $Arrayline["guideName"];
		$myCommisValue = $Arrayline["value"];
		}


	$query = "SELECT *
				FROM systemSetup";
	$result = mysqli_query($dbConn, $query);
	while($Arrayline = mysqli_fetch_assoc($result)) {
		$mySetupFlatRate = $Arrayline["flatRate"];
		$mySetupTAXRate  = $Arrayline["taxRate"];
		}


	$queryTwo = "SELECT * FROM surcharges";
	$resultTwo = mysqli_query($dbConn2, $queryTwo);
	$myMonSurcharge = array();
	while($Surchline = mysqli_fetch_assoc($resultTwo)) {
		$myMonSurcharge[$Surchline["monthNo"]] = $Surchline["surchargePercent"];
		}


//print_r($myMonSurcharge);


//echo $query;

$mySQLFilter = "";

$mySQLFilter = " AND `date` >= '".$fromDate."'  AND `date` <= '".$EndDate."' AND completed=1";
//$mySQLFilter = " BETWEEN  ".$fromDate."   AND ".$EndDate."";


$mySQLFilter .= " AND tourGuideUid='".$tourguide."'";

 echo "<h5> Bookings for ".$myGuideName." from ".$fromDate." to ".$EndDate." @ Commission rate of :".$myCommisValue."%</h5>";

echo '<table>
  <tr>
    <th>Book Ref</th>
    <th>Dated</th>
    <th>Customer Name & Surname</th>
    <th>Price of Tour</th>
    <th>Surcharge Fee</th>
    <th>Price+Surch</th>
    <th>Commission Calc</th>
    <th>Flat Rate</th>

    <th>Total</th>
  </tr>';


	$query = "SELECT *,bookings.uid AS bookingID_fromDB,MONTH(bookings.dateTour) AS monthNo
				FROM bookings
				LEFT JOIN tours ON tours.uid = bookings.touruid
				LEFT JOIN tourGuide ON tourGuide.uid = bookings.tourGuideUid
				WHERE 1=1
				".$mySQLFilter."
				ORDER BY dateTour DESC";



	$result = mysqli_query($dbConn, $query);

	// show for debugging reasons!!! when this dont look like they are working!
//	echo  $query;

	$result = mysqli_query($dbConn, $query);
	$myNumberofrecs 		= 0;
	$myTotalValueofTours	= 0;
	$myTotalValueComms 		= 0;
	$myTotalFlatRateValues  = 0;
	$myTotalSurchargeValues = 0;
	while($Arrayline = mysqli_fetch_assoc($result)) {

		 $ThislineTotal = 0;

		 $myNumberofrecs++;
		 echo '<tr>';
		 echo '<td>'.$Arrayline['bookref'].'</td>';
		 echo '   </td>';
		 echo '   <td>'.$Arrayline['dateTour'].'</td>';
		 echo '   <td>'.$Arrayline['customerName']." ".$Arrayline['customerSurname'].'</td>';
		 echo '   <td align="right">&euro;&nbsp;'.number_format($Arrayline['Price'],2).'</td>';

		 echo '   <td align="right">';

         $mySurch =  $Arrayline['Price'] * ($myMonSurcharge[$Arrayline['monthNo']]/100);
         if ($mySurch>0){
	         echo "&euro;&nbsp;".$mySurch . "   (". $myMonSurcharge[$Arrayline['monthNo']]." %) ";
			$myTotalSurchargeValues +=  $mySurch;
			}


		 echo '   </td>';


		 echo '   <td>'.number_format($Arrayline['Price']+$mySurch,2).'</td>';

		 $myTotalValueofTours += $Arrayline['Price'];

         $myComm =  ($Arrayline['Price'] + $mySurch) * ($myCommisValue/100);

		 $myTotalValueComms  +=  $myComm;

		 $myTotalFlatRateValues += $mySetupFlatRate;

		 echo '   <td align="right">&euro;&nbsp;'.number_format($myComm,2).'</td>';
		 echo '   <td align="right">&euro;&nbsp;'.$mySetupFlatRate.'</td>';

		 $ThislineTotal = $myComm + $mySetupFlatRate;

 		 echo '   <td align="right">&euro;&nbsp;'.number_format($ThislineTotal,2).'</td>';
		 echo ' </tr>';

	}


	$myPayis = $myTotalValueComms + $myTotalFlatRateValues;

	echo'  <tr>
    <th></th>
    <th></th>
    <th>Tours : '.$myNumberofrecs.'</th>
    <th>&euro;&nbsp;'.number_format($myTotalValueofTours,2).'</th>
    <th>&euro;&nbsp;'.number_format($myTotalSurchargeValues,2).'</th>
    <th>&euro;&nbsp;'.number_format($myTotalValueofTours+$myTotalSurchargeValues,2).'</th>
    <th>&euro;&nbsp;'.number_format($myTotalValueComms,2).'</th>
    <th>&euro;&nbsp;'.number_format($myTotalFlatRateValues,2).'</th>
    <th>&euro;&nbsp;'.number_format($myPayis,2).'</th>
  </tr>';

  echo '</table>';

//	$mySetupTAXRate
$myTAXpayment = $myPayis * ($mySetupTAXRate/100);


echo '<hr><br><table width="50%">
  <tr>
    <th>Details</th>
    <th>Total</th>
  </tr>';

 echo '<tr>';
		 echo '<td>Total Earnings</td>';
		 echo '<td>&euro;&nbsp;'.number_format($myPayis,2).'</td>';
 echo '</tr>';
 echo '<tr>';
		 echo '<td>TO TAX MAN('.$mySetupTAXRate.'%)</td>';
		 echo '<td>&euro;&nbsp;'.number_format($myTAXpayment,2).'</td>';
 echo '</tr>';
 echo '<tr>';
		 echo '<td>Transfer in your Account</td>';
		 echo '<td><BIG><BIG>&euro;&nbsp;'.number_format($myPayis-$myTAXpayment,2).'</BIG></BIG></td>';
 echo '</tr>';

 echo '</table>';




 }



?>




</body>

