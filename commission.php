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

if ($procedure=="commission"){

echo '<table>
  <tr>
    <th>Commission ID</th>
    <th>Comms Description</th>
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
		 echo '<td>'.ucwords($Arrayline['description']).'</td>';

		 if ($Arrayline['commPercent'] > 0 ) {
			 echo '<td>'.$Arrayline['commPercent'].'% </td>';
		 }else {
			 echo '<td bgcolor="orange"><big>Please edit and update me</big></td>';
		 	}


		 echo '<td>';
		  echo '<a href="commission.php?procedure=comms_deleteme&cuid='.$Arrayline['uid'].'" title="This will delete me"><i class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
		  echo '<a href="commission.php?procedure=comms_editme&cuid='.$Arrayline['uid'].'" title="This will Edit me"><i class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
		 echo '</td>';
		echo '</tr>';



	}

  echo '</table>';


    //echo '<a href="commission.php?procedure=addnewcommlevel"><i class="fa fa-fw fa-plus fa-2x"></i>Add Commission Level</a>';
    echo '<button class="btn success"><a href="commission.php?procedure=addnewcommlevel"><i class="fa fa-handshake-o fa-lg" aria-hidden="true"></i> Add Commission Level</a></button>';


	}



if ($procedure=="addnewcommlevel"){

$Commname 		= $_REQUEST["Commname"] ;
$cpercentage 	= $_REQUEST["cpercentage"] ;
$wasiposted 	= $_REQUEST["wasiposted"] ;

$myerror = "Please complete the below!";


if ($wasiposted <> ""){

	$myerror ="";

	if ($cpercentage > 50){

	  $myerror .= "<br><br><br><BIG><BIG><BIG>Commision can NOT be bigger then 50% of the tour price</BIG></BIG></BIG>";

        }
        
        if ($cpercentage < 1){

            $myerror .= "<br><br><br><BIG><BIG><BIG>Commission can NOT be Less than 1% of the tour price</BIG></BIG></BIG>";
      
              }


}

echo $myerror;


echo '
  <form action="commission.php?procedure=addnewcommlevel" method="post">
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

    $myNewGuid = guid();

    // added the `` around value and im worried it a reserved word in SQL, i dont take chances with such words.rather
    // safe then a SQL error
     $query = "INSERT INTO commLevel (guid,description,commPercent) VALUES (".
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
	$fromDB 	= $_REQUEST["fromDB"] ;
    $wasiposted = $_REQUEST["wasiposted"] ;
	$myerror    = ""; // use this for any validation we need!

    // debugging information
   ////echo "<H1>".$tuid."</H1>";


	if ($fromDB==""){

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
  <input type="hidden" name="fromDB" value="no">
  <input type="hidden" name="wasiposted" value="yes">
  <input type="submit" value="Submit">
  </form>';



   if ($myerror=="" && $fromDB <> ""){

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


</body>

