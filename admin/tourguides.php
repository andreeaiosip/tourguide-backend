<?php
$guideName		= $_REQUEST["guideName"];
$guideSurname 	= $_REQUEST["guideSurname"];
$commLevel  	= $_REQUEST["commLevel"];
$active 		= $_REQUEST["active"];
$guideUid		= $_REQUEST["guideUid"];


$procedure = $_REQUEST["procedure"] ;
include('myDBConnection.php');
include('commonFunctions.php');
include('deleteFunction.php');



 ?>
 
 <!DOCTYPE html>
 <html>
 <meta name ="viewport" content="width=device-width, initial-scale=1">
 <link rel  ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel  ="stylesheet" href="../assets/css/style.css">
 <body>
 
 
 <?php
 
 include('menuTabs.php');
 ?>
 
 
 <?php
 
 
 echo $procedure;

 if ($procedure=="tourguides"){

	echo '<table>
	  <tr>
		<th>Tour Guide ID</th>
		<th>Guide Name</th>
		<th>Tour Name</th>
		<th>Tour Price</th>
		<th>Action</th>
	  </tr>';
	
		$query = "SELECT * FROM tourGuide";
		$result = mysqli_query($dbConn, $query);
		while($Arrayline = mysqli_fetch_assoc($result)) {
			 echo '<tr>';
			   echo '<td>';
			   echo $Arrayline['uid'];
			   echo '</td>';
			   echo '<td>'.strtoupper($Arrayline['guideName']).'</td>';
			   echo '<td>'.ucwords($Arrayline['TourName']).'</td>';
			   echo '<td>'.$Arrayline['Price'].'</td>';
			   echo '<td>';
			   echo '<a href="tourguides.php?procedure=deleteTourGuide&guideUid='.$Arrayline['uid'].'" title="This will delete me"><i class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
			   echo '<a href="tourguides.php?procedure=guides_editme&guideUid='.$Arrayline['uid'].'" title="This will Edit me"><i class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
			   echo '</td>';
			 echo '</tr>';
		}
	  echo '</table>';
	

	  echo '<button class="btn success"><a href="tourguides.php?procedure=addnewtourguide"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Add Guide</a></button>';
	
	
	 }
	 if ($procedure=="deleteTourGuide"){

	
		Delete_A_record($dbConn,"tourGuide",$guideUid);
	
		echo '<meta http-equiv="refresh" content="0;url=tourguides.php?procedure=tourguides&showSnack=Record Deleted! successfully..." />';
	
		}


 
// ADD NEW TOUR------------------
 
 
if ($procedure=="addnewtourguide"){
 
	$wasiposted 	= $_REQUEST["wasiposted"] ;
	
	$myerror = "Please complete the below!";
	
	
	if ($wasiposted<> ""){
	
		if (strlen($Desc) < 15){
	
		  $myerror .= "<br><br><br><BIG><BIG><BIG>Please enter a more comprehensive description</BIG></BIG></BIG>";
	
			}
	
	}
	
	echo $myerror;
	
	
	
	echo '
	  <form action="tourguides.php">
	  <input type="hidden" name="procedure" value= '.$procedure.'>
	  <label for="guideName">Guide Name:</label><br>
	  <input type="text" id="guideName" name="guideName" required value="'.$guideSurname.'"><br>
	  <label for="guideSurname">Guide Surname:</label><br>
	  <input type="text" id="guideSurname" size="30" name="guideSurname" required value="'.$guideSurname.'"><br><br>
	  <label for="commLevel">Comm Level:</label><br>
	  <input type="text" id="commLevel" name="commLevel" required value="'.$commLevel.'"><br><br>
	  <input type="hidden" name="wasiposted" value="formposted">
	  <input type="submit" value="Submit">
	  </form>';
	
	
	if ($wasiposted <> ""){
	
		 $query = "INSERT INTO tourGuide (guideName, guideSurname, commLevel) VALUES (".
					"'".$guideName."',".
					"'".$guideSurname."',".
					"'".$commLevel."')";
	
	   
		$result = mysqli_query($dbConn, $query);
	
	
		echo "Record added successfully...";
	
		echo '<meta http-equiv="refresh" content="0;url=tourguides.php?procedure=tourguides" />';
	
		}
	
	 }

 
 
 if ($procedure=="editme"){
 
	 $uid 	  = $_REQUEST["uid"] ;
	 $fromDB  = $_REQUEST["fromDB"] ;
	 $myerror = ""; // use this for any validation we need!
 
	 if ($fromDB==""){
 
		 $query = "SELECT * FROM tourGuide WHERE uid='".$uid."'";
		 $result = mysqli_query($dbConn, $query);
		 while($Arrayline = mysqli_fetch_assoc($result)) {
			 $guideName 	= $Arrayline["guideName"];
			 $guideSurname 	= $Arrayline["guideSurname"];
             $commLevel = $Arrayline["commLevel"];
             $active 	= $Arrayline["active"];
			 }
 
		 }else{
 
			 $guideName 	= $_REQUEST["guideName"];
			 $guideSurname	= $_REQUEST["guideSurname"];
             $commLevel = $_REQUEST["commLevel"];
             $active	= $_REQUEST["active"];
			 }
 

 if ($myerror=="" && $fromDB <> ""){
 
	  $query = "UPDATE tourGuide SET guideName='".addslashes($guideName)."',guideSurname='".addslashes($guideSurname)."'commLevel='".addslashes($commLevel)."',active='".$active."' WHERE uid='".$uid."'";
	 $result = mysqli_query($dbConn, $query);
 
	 echo "Record updated successfully...";
 
	 echo '<meta http-equiv="refresh" content="0;url=tourguides.php?procedure=tourguides" />';
 
	 }
 
  }
 

 ?>

 </body>
 
 