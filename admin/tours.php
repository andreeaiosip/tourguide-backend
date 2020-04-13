<?php

session_start();

$date   = $_REQUEST["dateTour"];
$tours  = $_REQUEST["mytourselected"];
$saveme = $_REQUEST["saveme"];
$tuid   = $_REQUEST["tuid"];
$fromDB = $_REQUEST["fromDB"];
$Price  = $_REQUEST["Price"];
$Tname  = $_REQUEST["TourName"];
$Desc   = $_REQUEST["Description"];



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
echo 'Logged in as: ' . $_SESSION["accessRole"];
echo '</p>';
echo '</div>';

?>
 </div>
 
 <?php


if ($procedure == "deleteTour") {
    Delete_A_record($dbConn, "tours", $tuid);
    echo '<meta http-equiv="refresh" content="0;url=tours.php?procedure=tours&showSnack=Record Deleted! successfully..." />';
    
}

// EDIT TOUR------------------------

if ($procedure == "editTour") {
    
    echo '
 <div class=" container container-form">
       <form action="tours.php">
	   <input type="hidden" name="procedure" value= ' . $procedure . '>
	   <h3>UPDATE THIS TOUR</h3>
	   <br>
	   <br>
       <input type="hidden" name="tuid" value=' . $tuid . '>
       <label for="TourName">Tour name:</label><br>
       <input type="text" id="Tname" name="TourName" required value="' . $Tname . '"><br>
       <label for="tourDescription">Tour Description:</label><br>
       <input type="text" id="Desc" size="150" name="Description" required value="' . $Desc . '"><br><br>
       <label for="tourPrice">Tour Price:</label><br>
       <input type="number" id="Price" name="Price" required value="' . $Price . '"><br><br>
       <input type="hidden" name="fromDB" value="no">
       <input type="submit" value="Submit">
       </form>
       </div>';
    
    if ($fromDB <> "") {
        
        $query  = "UPDATE tours SET TourName='" . addslashes($Tname) . "',Description='" . addslashes($Desc) . "',Price='" . $Price . "' WHERE uid='" . $tuid . "'";
        $result = mysqli_query($dbConn, $query);
        
        echo "Record updated successfully...";
        
        echo '<meta http-equiv="refresh" content="0;url=tours.php?procedure=tours" />';
    }
}


/*SHOW TOURS ----------------------*/

if ($procedure == "tours") {
    
    echo ' <form>
 <table>
   <tr>
     <th>Tour ID</th>
     <th>Tour Name</th>
     <th>Tour Description</th>
     <th>Tour Price</th>
     <th>Action</th>
   </tr>';
    
    $query  = "SELECT * FROM tours";
    $result = mysqli_query($dbConn, $query);
    while ($Arrayline = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>';
        echo $Arrayline['uid'];
        echo '</td>';
        echo '<td name="TourName">' . strtoupper($Arrayline['TourName']) . '</td>';
        echo '<td name="Description">' . ucwords($Arrayline['Description']) . '</td>';
        echo '<td name="Price">€ ' . $Arrayline['Price'] . '</td>';
        echo '<td>';
        echo '<a href="tours.php?procedure=deleteTour&tuid=' . $Arrayline['uid'] . '" title="Delete me"><i style="color: #323232bf" class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
        echo '<a href="tours.php?procedure=editTour&tuid=' . $Arrayline['uid'] . '" title="Edit me"><i style="color:#323232bf" class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</form>';
    echo '<button style="border-radius:4px; text-decoration: none; margin-left: 50px;" class="btn success "><a href="tours.php?procedure=addnewtour" style="text-decoration:none;><i class="fa fa-fw fa-bus fa-2x" aria-hidden="true"></i> NEW</a></button>';

}

// ADD NEW TOUR------------------


if ($procedure == "addnewtour") {
    
    $wasiposted = $_REQUEST["wasiposted"];

    if ($wasiposted <> "") {
        
        if (strlen($Desc) < 15) {
            
            $myerror .= "<h4>Please enter a more comprehensive description</h4>"; 
        } 
    }
    
    echo $myerror;

    echo '
 <div class=" container container-form">
   <form action="tours.php"> 
   <h3>ADD NEW TOUR</h3>
   <br>
   <br>
   <input type="hidden" name="procedure" value= ' . $procedure . '>
  
   <label for="TourName">Tour name:</label><br>
   <input type="text" id="Tname" name="TourName" required value="' . $Tname . '"><br>
   <label for="Description">Tour Description:</label><br>
   <input type="text" id="Desc" size="150" name="Description" required value="' . $Desc . '"><br><br>
   <label for="Price">Tour Price:</label><br>
   <input type="number" id="Price" name="Price" required value="' . $Price . '"><br><br>
   <input type="hidden" name="wasiposted" value="formposted">
   <input type="submit" value="Submit">
   </form>
   </div>';
    
    
    if ($wasiposted <> "") {
        
        $query = "INSERT INTO tours (TourName, Description, Price) VALUES (" . "'" . $Tname . "'," . "'" . $Desc . "'," . "'" . $Price . "')";
 
        $result = mysqli_query($dbConn, $query);

        echo "Record added successfully...";
        echo '<meta http-equiv="refresh" content="0;url=tours.php?procedure=tours" />';

    }  
}

?>

 </body>
 
 </html>