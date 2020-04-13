<?php

session_start();

$commDescription = $_REQUEST["commDescription"];
$commPercent     = $_REQUEST["commPercent"];
$wasiposted      = $_REQUEST["wasiposted"];
$cuid            = $_REQUEST["cuid"];
$fromDB          = $_REQUEST["fromDB"];
$procedure       = $_REQUEST["procedure"];

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
    echo '<body>';
}

include('menuTabs.php');
echo '<div class="sessionRole">';
echo '<p>';
echo 'Logged in as: ' . $_SESSION["accessRole"];
echo '</p>';
echo '</div>';



// SHOW COMMISSION TABLE
if ($procedure == "commission") {
    
    echo '<table>
  <tr>
    <th>Commission ID</th>
    <th>Comms Level</th>
    <th>Commission Rate</th>
    <th>Action</th>
  </tr>';
    
    $query  = "SELECT * FROM commLevel";
    $result = mysqli_query($dbConn, $query);
    while ($Arrayline = mysqli_fetch_assoc($result)) {
        
        echo '<tr>';
        echo '<td>';
        echo $Arrayline['uid'];
        echo '</td>';
        echo '<td>' . ucwords($Arrayline['commDescription']) . '</td>';
        
        if ($Arrayline['commPercent'] > 0) {
            echo '<td>' . $Arrayline['commPercent'] . '% </td>';
        } else {
            echo '<td bgcolor="orange"><big>Please edit and update me</big></td>';
        }
        
        
        echo '<td>';
        echo '<a href="commission.php?procedure=deleteComm&cuid=' . $Arrayline['uid'] . '" title="Delete me"><i style="color:#323232bf" class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
        echo '<a href="commission.php?procedure=editComm&cuid=' . $Arrayline['uid'] . '" title="Edit me"><i style="color:#323232bf" class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
        echo '</td>';
        echo '</tr>';
        
    }
    
    echo '</table>';
    
    echo '<button class="btn success" style="border-radius:4px; margin-left: 50px;"><a href="commission.php?procedure=addCommLevel" style="text-decoration:none"><i class="fa fa-handshake-o fa-2x" aria-hidden="true"></i> NEW</a></button>';
    
    
}

// DELETE COMMISION RECORD

if ($procedure == "deleteComm") {
    
    
    Delete_A_record($dbConn, "commLevel", $cuid);
    
    echo '<meta http-equiv="refresh" content="0;url=commission.php?procedure=commission&showSnack=Record Deleted! successfully..." />';
    
}


// ADD COMMISSION LEVEL

if ($procedure == "addCommLevel") {
    
    
    if ($wasiposted <> "") {
        
        $myerror = "";
        
        if ($cpercentage > 50) {
            
            $myerror .= "<h2 style='text-align:center';>Commision can NOT be bigger then 50% of the tour price</h2>";
        }
        
        if ($commPercent < 1) {
            
            $myerror .= "<br><br><br><h2> style='text-align:center';>Commission can NOT be Less than 1% of the tour price</h2>";
        }
        
    }
    
    echo $myerror;
    
    
    echo '

  
  <div class=" container container-form">
  <form action="commission.php?procedure=addCommLevel" method="post">
  <h3>ADD NEW COMMISSION LEVEL</h3>
  <input type="hidden" name="procedure" value= ' . $procedure . '>
  <label for="commDescription">Commission</label><br>
  <input type="text" id="commDescription" name="commDescription" required value="' . $commDescription . '"><br>
  <label for="commPercent">Comm Percentage:</label><br>
  <input type="number" min="1" max="100" step="any" id="commPercent" name="commPercent" required value="' . $commPercent . '"><br><br>
  <input type="hidden" name="wasiposted" value="formposted">
  <input type="submit" value="Submit">
  </form>
  </div>';
    
    
    
    if ($myerror == "" && $wasiposted <> "") {
        
        $newCommUid = generateUid();
        $query      = "INSERT INTO commLevel (uid,commDescription,commPercent) VALUES (" . "'" . $newCommUid . "'," . "'" . $commDescription . "'," . "'" . $commPercent . "')";
        $result     = mysqli_query($dbConn, $query);
        echo "Record added successfully...";
        echo '<meta http-equiv="refresh" content="0;url=commission.php?procedure=commission&showSnack=Record added successfully..." />';
    }
    
}


if ($procedure == "editComm") {
    
    $myerror = "";
    
    if ($fromDB == "") {
        
        $query  = "SELECT * FROM commLevel WHERE uid='" . $cuid . "'";
        $result = mysqli_query($dbConn, $query);
        while ($Arrayline = mysqli_fetch_assoc($result)) {
            $commDescription = $Arrayline["commDescription"];
            $commPercent     = $Arrayline["value"];
        }
    } else {
        
        $commDescription = $_REQUEST["commDescription"];
        $commPercent     = $_REQUEST["commPercent"];
    }
    
    $myerror = "";
    
    
    if ($wasiposted <> "") {
        
        $myerror = "";
        
        if ($commPercent > 50) {
            
            $myerror .= "<br><BIG><BIG>Commission can NOT be bigger then 50% of the tour price</BIG></BIG></BIG>";
        }
        
        if ($commPercent == 0) {
            
            $myerror .= "<br><BIG><BIG>Commission must be more than Zero!!!</BIG></BIG></BIG>";
            
        }
    }
    
    echo '

<div class=" container container-form">
       <form action="commission.php">
       <input type="hidden" name="procedure" value= ' . $procedure . '>
       <h3>UPDATE THIS COMMISSION LEVEL</h3>
       <br>
       <br>
       <input type="hidden" name="cuid" value=' . $cuid . '>
       <label for="commDescription">Commission</label><br>
       <input type="text" id="commDescription" name="commDescription" required value="' . $commDescription . '"><br>
       <label for="commPercent">Comm Percentage:</label><br>
       <input type="number" id="commPercent" name="commPercent" required value="' . $commPercent . '"><br><br>
       <input type="hidden" name="fromDB" value="no">
       <input type="submit" value="Submit">
       </form>
       </div>';
    
    if ($myerror == "" && $fromDB <> "") {
        
        $query  = "UPDATE commLevel SET commDescription='" . addslashes($commDescription) . "',commPercent='" . addslashes($commPercent) . "' WHERE uid='" . $cuid . "'";
        $result = mysqli_query($dbConn, $query);
        
        echo '<meta http-equiv="refresh" content="0;url=commission.php?procedure=commission&showSnack=' . $commDescription . '- Record updated successfully..." />';
        
    }
}

if (isset($_REQUEST["showSnack"])) {
    echo '<div id="snackbar">' . $_REQUEST["showSnack"] . '</div>';
}

?>

<script src="./assets/js/app.js"></script>
</body>
</html>