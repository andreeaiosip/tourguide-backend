<?php

session_start();

$show         = $_REQUEST["show"];
$mySQLFilter  = "";
$bguid        = $_REQUEST["bguid"];
$procedure    = $_REQUEST["procedure"];
$tourGuideUid = $_REQUEST["tourGuideUid"];
$completed    = $_REQUEST["completed"];
$fromDB       = $_REQUEST["fromDB"];

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


if (isset($_REQUEST["showSnack"])) {
    echo '<body class="body-height" onload="myFunction()">';
} else {
    echo '<body class="body-height">';
}

include('menuTabs.php');
echo '<div class="sessionRole">';
echo '<p>';
echo 'Logged in as: ' . $_SESSION["accessRole"];
echo '</p>';
echo '</div>';

// SHOW BOOKINGS ON THE PAGE ----------------
if ($procedure == "bookings") {

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
    
    $query  = "SELECT *,bookings.guid AS bguid
                FROM bookings
                LEFT JOIN tours ON tours.uid = bookings.tourUid 
                LEFT JOIN tourGuide ON tourGuide.uid =  bookings.tourGuideUid";
    $result = mysqli_query($dbConn, $query);
    while ($Arrayline = mysqli_fetch_assoc($result)) {
        
        echo '<tr>
            <td>' . $Arrayline['tourUid'] . '</td>
            <td>' . $Arrayline['bookref'] . '</td>
            <td>' . $Arrayline['dateTour'] . '</td>
            <td>' . $Arrayline['customerName'] . " " . $Arrayline['customerSurname'] . '</td>
            <td>' . $Arrayline['TourName'] . '</td>
            <td>' . $Arrayline['Pax'] . '</td>
            <td>' . $Arrayline['guideName'] . '</td>';
        if ($Arrayline['completed'] == "0") {
            echo '<td><i style="color: #323232bf" class="fa fa-times-circle fa-2x" aria-hidden="true"></i></td>';
        } else {
            echo '<td> <i style="color: #323232bf" class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i></td>';
        }

        echo '<td>';
        if ($_SESSION["accessRole"] == "Adm") {
            echo '<a href="bookings.php?procedure=deleteBooking&bguid=' . $Arrayline['bguid'] . '" title="Delete Booking"><i style="color: #323232bf" class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
            echo '<a href="bookings.php?procedure=editBooking&bguid=' . $Arrayline['bguid'] . '" title="Assign a tour guide"><i style="color:#323232bf" class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
            
        } else {
            echo '<a href="bookings.php?procedure=editBooking&bguid=' . $Arrayline['bguid'] . '" title="Assign a tour guide"><i style="color:#323232bf" class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
            
        }
        echo '</td>';
        echo '</tr>';

    }
    
    echo '</table>';
}


if ($procedure == "isComplete") {
 
    echo $bguid;
}


if ($procedure == "editBooking") {
    
    $query  = "SELECT * FROM tourGuide";
    $result = mysqli_query($dbConn, $query);
    
    
    echo '
        <div class=" container container-form">
              <form action="bookings.php">
              <input type="hidden" name="procedure" value= ' . $procedure . '>
              <input type="hidden" name="bguid" value=' . $bguid . '>
              <h3>UPDATE BOOKING</h3>
              <br>
              <label for="TourGuide">Tour Guide:</label><br>
              <select name="tourGuideUid">
              
             <option value="">NONE</option>';
    while ($Arrayline = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $Arrayline['uid'] . '">' . $Arrayline['guideName'] . " " . $Arrayline['guideSurname'] . '</option>';
    }
    
    echo '</select><br>

              <label for="completed">Completed:</label><br>
              <select name="completed">
                 <option value="1">Completed</option>
                 <option value="0">Not completed</option>
              </select>
              <input type="hidden" name="fromDB" value="no">
              <input type="submit" value="Submit">
              </form>
              <h4>You cannot mark a booking as being completed without assigning a tour guide.</h4>
              </div>';
    
    if ($fromDB <> "" && !($completed == 1 && $tourGuideUid == "")) {
        
        $query  = "UPDATE bookings SET tourGuideUid='" . addslashes($tourGuideUid) . "',completed='" . addslashes($completed) . "' WHERE guid='" . $bguid . "'";
        $result = mysqli_query($dbConn, $query);
        
        echo "Record updated successfully...";
        
        echo '<meta http-equiv="refresh" content="0;url=bookings.php?procedure=bookings" />';
    }
    
    else {
        echo '<h4>Please assign a tour guide before marking the booking as being completed.</h4>';
    }  
}


// DELETE BOOKING----------------

if ($procedure == "deleteBooking") {
    
    $bookingGuid = $_REQUEST["bguid"];
    
    $query  = "DELETE FROM bookings WHERE guid='" . $bookingGuid . "'";
    $result = mysqli_query($dbConn, $query);
    echo '<meta http-equiv="refresh" content="0;url=bookings.php?procedure=bookings&showSnack=Record Deleted! successfully..." />';   
}

if (isset($_REQUEST["showSnack"])) {
    echo '<div id="snackbar">' . $_REQUEST["showSnack"] . '</div>';
}

?>
</body>
</html>
