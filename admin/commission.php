<?php

$commDescription = $_REQUEST["commDescription"] ;
$commPercent 	 = $_REQUEST["commPercent"] ;
$wasiposted 	 = $_REQUEST["wasiposted"] ;
$cuid 	  		 = $_REQUEST["cuid"] ;
$fromDB 		 = $_REQUEST["fromDB"] ;
$procedure		 = $_REQUEST["procedure"] ;

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
	echo '<body onload="myFunction()">';
}else {
	echo '<body>';
	}

 include('menuTabs.php');

if ($procedure=="commission"){

echo '<table>
  <tr>
    <th>Commission ID</th>
    <th>Comms Level</th>
    <th>Commission Rate</th>
    <th>Action</th>
  </tr>';

	$query = "SELECT * FROM commLevel";
	$result = mysqli_query($dbConn, $query);
	while($Arrayline = mysqli_fetch_assoc($result)) {

		echo '<tr>';
	     echo '<td>';
		     echo $Arrayline['uid'];
		 echo '</td>';
		 echo '<td>'.ucwords($Arrayline['commDescription']).'</td>';

		 if ($Arrayline['commPercent'] > 0 ) {
			 echo '<td>'.$Arrayline['commPercent'].'% </td>';
		 }else {
			 echo '<td bgcolor="orange"><big>Please edit and update me</big></td>';
		 	}


		 echo '<td>';
		  echo '<a href="commission.php?procedure=deleteCommLevel&cuid='.$Arrayline['uid'].'" title="Delete me"><i class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
		  echo '<a href="commission.php?procedure=editCommLevel&cuid='.$Arrayline['uid'].'" title="Edit me"><i class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
		 echo '</td>';
		echo '</tr>';



	}

  echo '</table>';


    //echo '<a href="commission.php?procedure=addCommLevel"><i class="fa fa-fw fa-plus fa-2x"></i>Add Commission Level</a>';
    //echo '<button class="btn success"><a href="commission.php?procedure=editCommLevel"><i class="fa fa-handshake-o fa-lg" aria-hidden="true"></i> Edit Commission Level</a></button>';


	}



if ($procedure=="addCommLevel"){



$myerror = "Please complete the below!";


if ($wasiposted <> ""){

	$myerror ="";

	if ($cpercentage > 50){

	  $myerror .= "<br><br><br><BIG><BIG><BIG>Commision can NOT be bigger then 50% of the tour price</BIG></BIG></BIG>";

        }
        
        if ($commPercent < 1){

            $myerror .= "<br><br><br><BIG><BIG><BIG>Commission can NOT be Less than 1% of the tour price</BIG></BIG></BIG>";
      
              }


}

echo $myerror;


echo '
  <form action="commission.php?procedure=addCommLevel" method="post">
  <label for="fname">Commission Level </label><br>
  <input type="text" id="commDescription" name="commDescription" required value="'.$commDescription.'"><br>
  <label for="lname">Commission Percentage:</label><br>
  <input type="number" id="commPercent" name="commPercent" required value="'.$commPercent.'"><br><br>
  <input type="hidden" name="wasiposted" value="formposted">
  <input type="submit" value="Submit">
  </form>';

// debugging info
//echo "Third<HR>";
// debugging informtion
//echo "<BR><BIG>my Errr : ".$myerror."</BIG>";
//echo "<BR><BIG>my Was posted : ".$wasiposted."</BIG>";

if ($myerror=="" && $wasiposted <> ""){

   // debugging info
   //echo "Fourth<HR>";

    $newCommUid = generateUid();

    // added the `` around value and im worried it a reserved word in SQL, i dont take chances with such words.rather
    // safe then a SQL error
     $query = "INSERT INTO commLevel (uid,commDescription,commPercent) VALUES (".
                "'".$newCommUid."',".     
				"'".$commDescription."',".
				"'".$commPercent."')";

	$result = mysqli_query($dbConn, $query);


    echo "Record added successfully...";

	echo '<meta http-equiv="refresh" content="0;url=commission.php?procedure=commission&showSnack=Record added successfully..." />';

	}


    // debugging info
  //echo "End of Procedure<HR>";


 }


if ($procedure=="editCommLevel"){

	
	$myerror    = ""; // use this for any validation we need!

    // debugging information
   ////echo "<H1>".$tuid."</H1>";


	if ($fromDB==""){

		$query = "SELECT * FROM commLevel WHERE uid='".$cuid."'";
		$result = mysqli_query($dbConn, $query);
		while($Arrayline = mysqli_fetch_assoc($result)) {
		    $commDescription 	 = $Arrayline["commDescription"];
	        $commPercent = $Arrayline["value"];
			}
		}else{

		    $commDescription    = $_REQUEST["commDescription"];
	        $commPercent = $_REQUEST["commPercent"];

			}

$myerror = "";


if ($wasiposted <> ""){

	$myerror ="";

	if ($commPercent > 50){

	  $myerror .= "<br><BIG><BIG>Commission can NOT be bigger then 50% of the tour price</BIG></BIG></BIG>";

		}


	if ($commPercent == 0){

	  $myerror .= "<br><BIG><BIG>Commission must be more than Zero!!!</BIG></BIG></BIG>";

		}

}

echo $myerror." - Hey maybe add some styling here... to make it a little more pretty....";



echo '
  <form action="commission.php?procedure=editCommLevel&cuid='.$cuid.'" method="post">
  <label for="commDescription">Commission Level </label><br>
  <input type="text" id="commDescription" name="commDescription" required value="'.$commDescription.'"><br>
  <label for="commPercent">Commission Percentage:</label><br>
  <input type="number" min="1" max="100" step="any" id="commPercent" name="commPercent" required value="'.$commPercent.'"><br><br>
  <input type="hidden" name="fromDB" value="no">
  <input type="hidden" name="wasiposted" value="yes">
  <input type="submit" value="Submit">
  </form>';



   if ($myerror=="" && $fromDB <> ""){

 	$query = "UPDATE commission SET commDescription='".addslashes($commDescription)."',value='".addslashes($commPercent)."' WHERE uid='".$cuid."'";
	$result = mysqli_query($dbConn, $query);

    echo "Commission record updated successfully...";

	echo '<meta http-equiv="refresh" content="0;url=commission.php?procedure=commission&showSnack='.$commDescription.'- Record updated successfully..." />';

	}

 }


if (isset($_REQUEST["showSnack"])){
	echo '<div id="snackbar">'.$_REQUEST["showSnack"].'</div>';
	}

?>

<script src="./assets/js/app.js"></script>
</body>

