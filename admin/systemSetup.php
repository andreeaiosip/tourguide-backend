<?php

  $procedure = $_REQUEST["procedure"] ;

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


if (isset($_REQUEST["showSnack"])){
	echo '<body onload="myFunction()">';
}else {
	echo '<body>';
	}

 include('menuTabs.php');

if ($procedure=="systemSetup"){

echo '<table>
  <tr>
    <th>User ID</th>
    <th>Name</th>
    <th>Password</th>
    <th>Tour Guide</th>
    <th>User Role</th>
    <th>Action</th>
  </tr>';

	$query = "SELECT *,user.uid AS userUid 
    FROM user
    LEFT JOIN tourGuide ON tourGuide.uid = user.tourGuideUid";
	$result = mysqli_query($dbConn, $query);
	while($Arrayline = mysqli_fetch_assoc($result)) {

		echo '<tr>';
	     echo '<td>';
             echo $Arrayline['userUid'];
          echo '</td>';
         
		 echo '<td>'.$Arrayline['username'].'</td>';
         echo '<td>'.$Arrayline['password'].'</td>';
         echo '<td>'.$Arrayline['guideName'].' '.$Arrayline['guideSurname'].'</td>';
         echo '<td>'.$Arrayline['accessRole'].'</td>';
		 

//Check action column!
		 echo '<td>';
		  echo '<a href="systemSetup.php?procedure= //comms_deleteme&cuid='.$Arrayline['userUid'].'" title="This will delete me"><i class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
		  echo '<a href="systemSetup.php?procedure=//comms_editme&cuid='.$Arrayline['userUid'].'" title="This will Edit me"><i class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
		 echo '</td>';
		echo '</tr>';

	}

	

  echo '</table>';


    //echo '<a href="commission.php?procedure=addnewcommlevel"><i class="fa fa-fw fa-plus fa-2x"></i>Add Commission Level</a>';
    echo '<button class="btn success"><a href="systemSetup.php?procedure=addNewUser"><i class="fa fa-handshake-o fa-lg" aria-hidden="true"></i> Add Commission Level</a></button>';


	}



if ($procedure=="addNewUser"){

$username 		= $_REQUEST["username"] ;
$password 	= $_REQUEST["password"] ;
$accessRole 	= $_REQUEST["accessRole"] ;
$tourGuide 	= $_REQUEST["tourGuide"];
$wasiposted 	= $_REQUEST["wasiposted"];

$myerror = "Please complete the below!";


if ($wasiposted <> ""){

	$myerror ="";

	if ($cpercentage == " "){

	  $myerror .= "<br><br><br><BIG><BIG><BIG>Please enter a username</BIG></BIG></BIG>";

        }
        
        if ($cpercentage < 1){

            $myerror .= "<br><br><br><BIG><BIG><BIG>Commission can NOT be Less than 1% of the tour price</BIG></BIG></BIG>";
      
              }


}

echo $myerror;


echo '
  <form action="systemSetup.php?procedure=addNewUser" method="post">
  <label for="fname">Commission Level </label><br>
  <input type="text" id="Commname" name="Commname" required value="'.$Commname.'"><br>
  <label for="lname">Commission Percentage:</label><br>
  <input type="number" id="cpercentage" name="cpercentage" required value="'.$cpercentage.'"><br><br>
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

    $myNewUid = generateUid();

    // added the `` around value and im worried it a reserved word in SQL, i dont take chances with such words.rather
    // safe then a SQL error
     $query = "INSERT INTO commLevel (uid,description,commPercent) VALUES (".
                "'".$myNewGuid."',".     
				"'".$Commname."',".
				"'".$cpercentage."')";

	$result = mysqli_query($dbConn, $query);


    echo "Record added successfully...";

	echo '<meta http-equiv="refresh" content="0;url=commission.php?procedure=commission&showSnack=Record added successfully..." />';

	}


    // debugging info
  //echo "End of Procedure<HR>";


 }


if ($procedure=="comms_editme"){

	$cuid 	  	= $_REQUEST["cuid"] ;
	$DBvalue 	= $_REQUEST["DBvalue"] ;
    $wasiposted = $_REQUEST["wasiposted"] ;
	$myerror    = ""; // use this for any validation we need!

    // debugging information
   ////echo "<H1>".$tuid."</H1>";


	if ($DBvalue==""){

		$query = "SELECT * FROM commLevel WHERE uid='".$cuid."'";
		$result = mysqli_query($dbConn, $query);
		while($Arrayline = mysqli_fetch_assoc($result)) {
		    $Commname 	 = $Arrayline["description"];
	        $cpercentage = $Arrayline["value"];
			}
		}else{

		    $Commname    = $_REQUEST["Commname"];
	        $cpercentage = $_REQUEST["cpercentage"];

			}

$myerror = "";


if ($wasiposted <> ""){

	$myerror ="";

	if ($cpercentage > 50){

	  $myerror .= "<br><BIG><BIG>Commission can NOT be bigger then 50% of the tour price</BIG></BIG></BIG>";

		}


	if ($cpercentage == 0){

	  $myerror .= "<br><BIG><BIG>Commission must be more than Zero!!!</BIG></BIG></BIG>";

		}

}

echo $myerror." - Hey maybe add some styling here... to make it a little more pretty....";



echo '
  <form action="commission.php?procedure=comms_editme&cuid='.$cuid.'" method="post">
  <label for="Commname">Commission Level </label><br>
  <input type="text" id="Commname" name="Commname" required value="'.$Commname.'"><br>
  <label for="cpercentage">Commission Percentage:</label><br>
  <input type="number" id="cpercentage" name="cpercentage" required value="'.$cpercentage.'"><br><br>
  <input type="hidden" name="DBvalue" value="no">
  <input type="hidden" name="wasiposted" value="yes">
  <input type="submit" value="Submit">
  </form>';



   if ($myerror=="" && $DBvalue <> ""){

 	$query = "UPDATE commission SET description='".addslashes($Commname)."',value='".addslashes($cpercentage)."' WHERE uid='".$cuid."'";
	$result = mysqli_query($dbConn, $query);

    echo "Commission record updated successfully...";

	echo '<meta http-equiv="refresh" content="0;url=commission.php?procedure=commission&showSnack='.$Commname.'- Record updated successfully..." />';

	}

 }


if (isset($_REQUEST["showSnack"])){
	echo '<div id="snackbar">'.$_REQUEST["showSnack"].'</div>';
	}

?>

<script src="./assets/js/app.js"></script>
</body>
</html>

