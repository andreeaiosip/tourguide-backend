<?php

session_start();

$guideName    = $_REQUEST["guideName"];
$guideSurname = $_REQUEST["guideSurname"];
$commLevel    = $_REQUEST["commLevel"];
$active       = $_REQUEST["active"];
$guideUid     = $_REQUEST["guideUid"];
$fromDB       = $_REQUEST["fromDB"];

$procedure = $_REQUEST["procedure"];
include('myDBConnection.php');
include('commonFunctions.php');
include('deleteFunction.php');



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
echo '<div class="sessionRole">';
echo '<p>';
echo 'Logged in as: ' .	$_SESSION["accessRole"];
echo '</p>';
echo '</div>';

if ($procedure == "tourguides") {
    
    echo '<table>
      <tr>
        <th>Tour Guide ID</th>
        <th>Guide Name & Surname</th>
        <th>Experience Level</th>
        
        <th>Action</th>
      </tr>';
    
    $query  = "SELECT * FROM tourGuide";
    $result = mysqli_query($dbConn, $query);
    while ($Arrayline = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>';
        echo $Arrayline['uid'];
        echo '</td>';
        
        echo '<td>' . ucwords($Arrayline['guideName'] . " " . $Arrayline['guideSurname']) . '</td>';
        echo '<td>' . strtoupper($Arrayline['commLevel']) . '</td>';
        
        echo '<td>';
        echo '<a href="tourguides.php?procedure=deleteTourGuide&guideUid=' . $Arrayline['uid'] . '" title="Delete me"><i style="color:#323232bf" class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
        echo '<a href="tourguides.php?procedure=editTourGuide&guideUid=' . $Arrayline['uid'] . '" title="Edit me"><i style="color:#323232bf" class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
    
    
    echo '<button class="btn success" style="border-radius:4px; margin-left: 50px;"><a href="tourguides.php?procedure=addnewtourguide" style="text-decoration:none;"><i class="fa fa-user-circle-o fa-2x" aria-hidden="true"></i> NEW</a></button>';
    
    
}

// DELETE TOUR GUIDE-----------------

if ($procedure == "deleteTourGuide") {
    
    
    Delete_A_record($dbConn, "tourGuide", $guideUid);
    
    echo '<meta http-equiv="refresh" content="0;url=tourguides.php?procedure=tourguides&showSnack=Record Deleted! successfully..." />';
    
}



// ADD NEW TOUR GUIDE------------------


if ($procedure == "addnewtourguide") {
    
    $wasiposted = $_REQUEST["wasiposted"];
    
    $myerror = "Please complete the below!";
    
    
    if ($wasiposted <> "") {
        
        if (strlen($Desc) < 15) {
            
            $myerror .= "<br><br><br><BIG><BIG><BIG>Please enter a more comprehensive description</BIG></BIG></BIG>";
            
        }
        
    }
    
    echo $myerror;
    
    
    
    echo '
      <form action="tourguides.php">
      <input type="hidden" name="procedure" value= ' . $procedure . '>
      <label for="guideName">Guide Name:</label><br>
      <input type="text" id="guideName" name="guideName" required value="' . $guideName . '"><br>
      <label for="guideSurname">Guide Surname:</label><br>
      <input type="text" id="guideSurname" size="30" name="guideSurname" required value="' . $guideSurname . '"><br><br>
      <label for="commLevel">Comm Level:</label><br>
      <input type="text" id="commLevel" name="commLevel" required value="' . $commLevel . '"><br><br>
      <input type="hidden" name="wasiposted" value="formposted">
      <input type="submit" value="Submit">
      </form>';
    
    
    if ($wasiposted <> "") {
        
        $query = "INSERT INTO tourGuide (guideName, guideSurname, commLevel) VALUES (" . "'" . $guideName . "'," . "'" . $guideSurname . "'," . "'" . $commLevel . "')";
        
        
        $result = mysqli_query($dbConn, $query);
        
        
        echo "Record added successfully...";
        
        echo '<meta http-equiv="refresh" content="0;url=tourguides.php?procedure=tourguides" />';
        
    }
    
}



// EDIT TOUR GUIDE------------------------

if ($procedure == "editTourGuide") {
    
    echo '
    <form action="tourguides.php">
       <input type="hidden" name="procedure" value= ' . $procedure . '>
       <input type="hidden" name="guideUid" value=' . $guideUid . '>
       <label for="guideName">Guide Name:</label><br>
       <input type="text" id="guideName" name="guideName" required value="' . $guideName . '"><br>
       <label for="guideSurname">Guide Surname:</label><br>
       <input type="text" id="guideSurname" size="20" name="guideSurname" required value="' . $guideSurname . '"><br><br>
       <label for="commLevel">Comm Level:</label><br>
       <input type="text" id="commLevel" name="commLevel" required value="' . $commLevel . '"><br><br>
       <input type="hidden" name="fromDB" value="no">
       <input type="submit" value="Submit">
       </form>';
    
    if ($fromDB <> "") {
        
        $query  = "UPDATE tourGuide SET guideName='" . addslashes($guideName) . "',guideSurname='" . addslashes($guideSurname) . "',commLevel='" . $commLevel . "' WHERE tourGuide.uid='" . $guideUid . "'";
        $result = mysqli_query($dbConn, $query);
        
        echo "Record updated successfully...";
        
        echo '<meta http-equiv="refresh" content="0;url=tourguides.php?procedure=tourguides" />';
        
    }
}




?>


</body>


</html>

