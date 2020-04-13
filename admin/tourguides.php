<?php

session_start();

$guideName    = $_REQUEST["guideName"];
$guideSurname = $_REQUEST["guideSurname"];
$commLevelUid = $_REQUEST["commLevelUid"];
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
echo 'Logged in as: ' . $_SESSION["accessRole"];
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
    
    $query  = "SELECT *, tourGuide.uid AS tuid FROM tourGuide
    LEFT JOIN commLevel ON commLevelUid=commLevel.uid";
    $result = mysqli_query($dbConn, $query);
    while ($Arrayline = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>';
        echo $Arrayline['tuid'];
        echo '</td>';
        echo '<td>' . ucwords($Arrayline['guideName'] . " " . $Arrayline['guideSurname']) . '</td>';
        echo '<td>' . strtoupper($Arrayline['commDescription']) . '</td>';
        echo '<td>';
        echo '<a href="tourguides.php?procedure=deleteTourGuide&guideUid=' . $Arrayline['tuid'] . '" title="Delete me"><i style="color:#323232bf" class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
        echo '<a href="tourguides.php?procedure=editTourGuide&guideUid=' . $Arrayline['tuid'] . '" title="Edit me"><i style="color:#323232bf" class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
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

    if ($wasiposted <> "") {
        
        if (strlen($Desc) < 15) {  
        }
    }
 
    echo '
    <div class=" container container-form">
      <form action="tourguides.php">
      <input type="hidden" name="procedure" value= ' . $procedure . '>
      <h4>ADD NEW TOUR GUIDE</h4>
      <br>
      <br>
      <label for="guideName">Guide Name:</label><br>
      <input type="text" id="guideName" name="guideName" required value="' . $guideName . '"><br>
      <label for="guideSurname">Guide Surname:</label><br>
      <input type="text" id="guideSurname" size="30" name="guideSurname" required value="' . $guideSurname . '"><br><br>
      <label for="commLevel">Commission Level:</label><br>';
    echo '<SELECT name="commLevelUid" required>';
    echo "<OPTION value='NONE'>NONE SELECTED</OPTION>\n";

    $query  = "SELECT * FROM commLevel ORDER BY commDescription";
    $result = mysqli_query($dbConn, $query);
    while ($Arrayline = mysqli_fetch_assoc($result)) {
        
        echo "<OPTION value='" . $Arrayline["uid"] . "'";
        // uid is from the DB!
        if ($tourGuide == $Arrayline["uid"]) {
            echo " SELECTED";
        }
        echo ">" . $Arrayline["commDescription"] . "</OPTION>\n";
    }
    
    echo "</SELECT><br>";
    
    echo '
      <br><br>
      <input type="hidden" name="wasiposted" value="formposted">
      <input type="submit" value="Submit">
      </form>
      </div>';

    if ($wasiposted <> "") {
        $query = "INSERT INTO tourGuide (guideName, guideSurname, commLevelUid) VALUES (" . "'" . $guideName . "'," . "'" . $guideSurname . "'," . "'" . $commLevelUid . "')";
 
        $result = mysqli_query($dbConn, $query);
        echo "Record added successfully...";
        echo '<meta http-equiv="refresh" content="0;url=tourguides.php?procedure=tourguides" />';
    } 
}


// EDIT TOUR GUIDE------------------------

if ($procedure == "editTourGuide") {
    
    echo '
    <div class=" container container-form">
    <form action="tourguides.php">
       <input type="hidden" name="procedure" value= ' . $procedure . '>
       <input type="hidden" name="guideUid" value=' . $guideUid . '>
       <h4>UPDATE DETAILS OF A TOUR GUIDE</h4>
       <br>
       <BR>
       <label for="guideName">Guide Name:</label><br>
       <input type="text" id="guideName" name="guideName" required value="' . $guideName . '"><br>
       <label for="guideSurname">Guide Surname:</label><br>
       <input type="text" id="guideSurname" size="20" name="guideSurname" required value="' . $guideSurname . '"><br><br>
       <label for="commLevelUid">Comm Level:</label><br>';
    echo '<SELECT name="commLevelUid" required>';
    echo "<OPTION value='NONE'>NONE SELECTED</OPTION>\n";
    
    $query1  = "SELECT * FROM commLevel ORDER BY commDescription";
    $result1 = mysqli_query($dbConn, $query1);
    while ($Arrayline1 = mysqli_fetch_assoc($result1)) {   
        echo "<OPTION value='" . $Arrayline1["uid"] . "'";
        if ($commLevel == $Arrayline1["uid"]) {
            echo " SELECTED";
        }
        echo ">" . $Arrayline1["commDescription"] . "</OPTION>\n";   
    }
    
    echo "</SELECT><br>";
    echo '<br><br>
               <input type="hidden" name="fromDB" value="no">
               <input type="submit" value="Submit">
               </form>
               </div>';
 
    if ($fromDB <> "") {
        
        $query  = "UPDATE tourGuide SET guideName='" . addslashes($guideName) . "',guideSurname='" . addslashes($guideSurname) . "',commLevelUid='" . $commLevelUid . "' WHERE tourGuide.uid='" . $guideUid . "'";
        $result = mysqli_query($dbConn, $query);

        echo "Record updated successfully...";
        
        echo '<meta http-equiv="refresh" content="0;url=tourguides.php?procedure=tourguides" />';
        
    }
}

?>


</body>


</html>