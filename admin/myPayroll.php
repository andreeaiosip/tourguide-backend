<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();


$procedure = $_REQUEST["procedure"];
include('myDBConnection.php');
include('deleteFunction.php');

?>
 
 <!DOCTYPE html>
 <html>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="../assets/css/style.css">
    
 
 <body>
 

 <?php

include('menuTabs.php');
echo '<div class="sessionRole">';
echo '<p>';
echo 'Logged in as: ' .	$_SESSION["accessRole"];
echo '</p>';
echo '</div>';




if (isset($_REQUEST["showSnack"])) {
    echo '<body onload="myFunction()">';
} else {
    echo '<body>';
}

// if ($_SESSION["accessRole"] == "Adm") {
//     echo ' <a href="myPayroll.php?procedure=genpayroll"><button class="btn success" >Generate Payroll (Admin Side)</button></a>';
// } else {
//     echo ' <a href="myPayroll.php?procedure=genpayroll"><button class="btn success" >Calculate Pay (Tour Guide Side)</button></a>';
// }


if (isset($_REQUEST["showSnack"])) {
    echo '<div id="snackbar">' . $_REQUEST["showSnack"] . '</div>';
}

if ($procedure == "genpayroll") {
    
    
    
    echo '<br /><br /><br /><br />
    <div class=" container container-form">
          <form action="myPayroll.php?procedure=genpayrollView" method="post">
          <label for="FromDate">Start Payroll Date:(Inclusive)</label><br>
          <input type="date" id="FromDate" name="FromDate" required value="' . $FromDate . '"><br>
          <label for="EndDate">End Payroll Date:(Inclusive)</label><br>
          <input type="date" id="EndDate" name="EndDate" required value="' . $EndDate . '"><br><br>';
    
    if ($_SESSION["accessRole"] == "Adm") {
        
        echo '<label for="tourGuide">Tour guide:</label><br>';
        echo '<SELECT name="tourGuide" required>';
        echo "<OPTION value='NONE'>NONE SELECTED</OPTION>\n";
        
        
        
        $query  = "SELECT * FROM tourGuide ORDER BY guideName";
        $result = mysqli_query($dbConn, $query);
        while ($Arrayline = mysqli_fetch_assoc($result)) {
            
            echo "<OPTION value='" . $Arrayline["uid"] . "'";
            // uid is from the DB!
            if ($tourGuide == $Arrayline["uid"]) {
                echo " SELECTED";
            }
            echo ">" . $Arrayline["guideName"] . "</OPTION>\n";
            
        }
        
        echo "</SELECT><br>";

        // The below line is the main one that makes the tour guide payroll to show
    } else {
        echo '<input type="hidden" name="tourGuide" value="' . $_SESSION["TG_uid"] . '">';
    }
    echo '
          <input type="hidden" name="wasiposted" value="formposted">
          <input type="submit" value="Submit">
          </form>
          </div>';
    
}


if ($procedure == "genpayrollView") {
    
    $tourGuide = $_REQUEST["tourGuide"];
    $EndDate   = $_REQUEST["EndDate"];
    $FromDate  = $_REQUEST["FromDate"];
    
    // get the commision rate for the Guide and their Name.
    
    $query  = "SELECT *
                FROM tourGuide
                LEFT JOIN commLevel ON commLevel.uid = tourGuide.commLevelUid
                WHERE tourGuide.uid='" . $tourGuide . "'";
    $result = mysqli_query($dbConn, $query);
    while ($Arrayline = mysqli_fetch_assoc($result)) {
        $guideName   = $Arrayline["guideName"];
        $myCommisValue = $Arrayline["commPercent"];
    }
    
    // echo $query;
    // Get the Main values/Parameters in the part that gets calucualted
    $query  = "SELECT *
                FROM systemSetup";
    $result = mysqli_query($dbConn, $query);
    while ($Arrayline = mysqli_fetch_assoc($result)) {
        $mySetupFlatRate = $Arrayline["flatRate"];
        $mySetupTAXRate  = $Arrayline["taxRate"];
    }
    
    // Tourguide, dates for the Payroll, Commision , Name of Guide and we just for the LFAT and TAx rates.
    
    
    
    
    $queryTwo       = "SELECT * FROM surcharges";
    $resultTwo      = mysqli_query($dbConn, $queryTwo);
    $myMonSurcharge = array();
    while ($Surchline = mysqli_fetch_assoc($resultTwo)) {
        $myMonSurcharge[$Surchline["monthNo"]] = $Surchline["surchargePercent"];
    }
    
    
    //print_r($myMonSurcharge);
    
    
    //echo $query;
    
    $mySQLFilter = "";
    
    $mySQLFilter = " AND `dateTour` >= '" . $FromDate . "'  AND `dateTour` <= '" . $EndDate . "' AND completed=1";
    //$mySQLFilter = " BETWEEN  ".$fromDate."   AND ".$EndDate."";
    
    
    $mySQLFilter .= " AND tourGuideUid='" . $tourGuide . "'";
    
    echo "<h5> Bookings for " . $guideName . " from " . $FromDate . " to " . $EndDate . " @ Commission rate of :" . $myCommisValue . "%</h5>";
    
    echo '<table>
  <tr>
    <th>Book Ref</th>
    <th>Dated</th>
    <th>Customer Details</th>
    <th>No of Guests</th>
    <th>Tour Total</th>
    <th>Surcharge Fee</th>
    <th>Price+Surch</th>
    <th>Commission Calc</th>
    <th>Flat Rate</th>

    <th>Total</th>
  </tr>';
    
    
    $query = "SELECT *,bookings.guid AS bookingID_fromDB,MONTH(bookings.dateTour) AS monthNo
                FROM bookings
                LEFT JOIN tours ON tours.uid = bookings.tourUid
                LEFT JOIN tourGuide ON tourGuide.uid = bookings.tourGuideUid
                WHERE 1=1
                " . $mySQLFilter . "
                ORDER BY dateTour DESC";
    
    
    $result = mysqli_query($dbConn, $query);
    
    // show for debugging reasons!!! when this dont look like they are working!
    //    echo  $query;
    
    $result                 = mysqli_query($dbConn, $query);
    $myNumberofrecs         = 0;
    $myTotalValueofTours    = 0;
    $myTotalValueComms      = 0;
    $myTotalFlatRateValues  = 0;
    $myTotalSurchargeValues = 0;
    $myTotalGuestServed     = 0;
    while ($Arrayline = mysqli_fetch_assoc($result)) {
        
        $ThislineTotal = 0;
        $TotalofTour   = 0;
        // total number of Tours - FOR THE DATE RANGE
        $myNumberofrecs++;
        echo '<tr>';
        echo '<td><b>' . $Arrayline['bookref'] . '</b></td>';
        echo '   </td>';
        echo '   <td>' . $Arrayline['dateTour'] . '</td>';
        echo '   <td>' . $Arrayline['customerName'] . " " . $Arrayline['customerSurname'] . '</td>';
        echo '   <td>' . $Arrayline['Pax'] . " @&euro;&nbsp; " . number_format($Arrayline['Price'], 2) . '</td>';
        // total number of Persons served - FOR THE DATE RANGE
        $myTotalGuestServed += $Arrayline['Pax'];
        // Total of Tour - Number of persons * Price of the Tour
        $TotalofTour = $Arrayline['Pax'] * $Arrayline['Price'];
        echo '   <td align="right">&euro;&nbsp;' . number_format($TotalofTour, 2) . '</td>';
        
        echo '   <td align="right">';
        // work out the surcharge
        // Total of the tour * array element that matches the Month of the Date of the actual tour
        $mySurch = $TotalofTour * ($myMonSurcharge[$Arrayline['monthNo']] / 100);
        
        
        if ($mySurch > 0) {
            // print the surcharge and then show the user the percentage Surchage due for this month related
            // to the booking date
            echo "&euro;&nbsp;" . $mySurch . "   (" . $myMonSurcharge[$Arrayline['dateTour']] . " %) ";
            // add this lines surchage to the bigger tally
            $myTotalSurchargeValues += $mySurch;
        }
        
        
        echo '   </td>';
        
        // show the TotalTour price and the added surch for the tour
        echo '   <td>' . number_format($TotalofTour + $mySurch, 2) . '</td>';
        // add this to the tally of the tours
        $myTotalValueofTours += $TotalofTour;
        // calculate the Commision based on TotalTour Price + Surcharge * Commision Rate
        $myComm = ($TotalofTour + $mySurch) * ($myCommisValue / 100);
        
        // total this for the big total at the bottom
        $myTotalValueComms += $myComm;
        
        // Total up the Flat rate paid for each tour
        $myTotalFlatRateValues += $mySetupFlatRate;
        
        echo '   <td align="right">&euro;&nbsp;' . number_format($myComm, 2) . '</td>';
        echo '   <td align="right">&euro;&nbsp;' . $mySetupFlatRate . '</td>';
        // Tally up this lines values to show what it works out to be
        // COmmision calc plus the flat rate
        $ThislineTotal = $myComm + $mySetupFlatRate;
        
        echo '   <td align="right">&euro;&nbsp;' . number_format($ThislineTotal, 2) . '</td>';
        echo ' </tr>';
        
    }
    
    // Addition of the TotalCOmmisions plus the total of the flat rates
    $myPayis = $myTotalValueComms + $myTotalFlatRateValues;
    
    echo '  <tr>
    <th></th>
    <th></th>
    <th>Tours : ' . $myNumberofrecs . '</th>
    <th>' . $myTotalGuestServed . '</th>
    <th>&euro;&nbsp;' . number_format($myTotalValueofTours, 2) . '</th>
    <th>&euro;&nbsp;' . number_format($myTotalSurchargeValues, 2) . '</th>
    <th>&euro;&nbsp;' . number_format($myTotalValueofTours + $myTotalSurchargeValues, 2) . '</th>
    <th>&euro;&nbsp;' . number_format($myTotalValueComms, 2) . '</th>
    <th>&euro;&nbsp;' . number_format($myTotalFlatRateValues, 2) . '</th>
    <th>&euro;&nbsp;' . number_format($myPayis, 2) . '</th>
  </tr>';
    
    echo '</table>';
    
    //    $mySetupTAXRate
    $myTAXpayment = $myPayis * ($mySetupTAXRate / 100);
    
    
    echo '<hr><br><table width="50%">
  <tr>
    <th>Details</th>
    <th>Total</th>
  </tr>';
    
    echo '<tr>';
    echo '<td>Total Earnings</td>';
    echo '<td>&euro;&nbsp;' . number_format($myPayis, 2) . '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>TAX(' . $mySetupTAXRate . '%)</td>';
    echo '<td>&euro;&nbsp;' . number_format($myTAXpayment, 2) . '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>Salary to Transfer</td>';
    echo '<td><BIG><BIG>&euro;&nbsp;' . number_format($myPayis - $myTAXpayment, 2) . '</BIG></BIG></td>';
    echo '</tr>';
    
    echo '</table>';
    
    
    echo '<a href="payrollprt.php?tourguide=' . $tourGuide . '&EndDate=' . $EndDate . '&FromDate=' . $FromDate . '" target="_blank"><button class="btn success" >Print Payslip</button></a>';
    
    
    
}


?>
 

 </body>
 
 </html>