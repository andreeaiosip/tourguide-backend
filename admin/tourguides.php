<?php
$fName 		= $_REQUEST["guideName"];
$lName 		= $_REQUEST["guideSurname"];
$commLevel  = $_REQUEST["commLevel"];
$active 	= $_REQUEST["active"];



$procedure = $_REQUEST["procedure"] ;
include('myDBConnection.php');
include('commonFunctions.php');



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
			   // the guideuid is for PHP
			   // the uid is from the record set and im getting that from the DB!
			   echo '<a href="home.php?procedure=guides_deleteme&guideuid='.$Arrayline['uid'].'" title="This will delete me"><i class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
			   echo '<a href="home.php?procedure=guides_editme&guideuid='.$Arrayline['uid'].'" title="This will Edit me"><i class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
			   echo '</td>';
			 echo '</tr>';
		}
	
	  echo '</table>';
	
	//  echo '<button class="btn success">Add Guide</button>'; / started with this...
	  echo '<button class="btn success"><a href="home.php?procedure=addnewguide"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Add Guide</a></button>';
	
	
	 }
 
 if ($procedure=="deleteme"){
 
	 $uid 	   = $_REQUEST["uid"] ;
	 $query    = "DELETE FROM tourGuide WHERE uid='".$uid."'";
	 $result   = mysqli_query($dbConn, $query);
 
	 echo '<meta http-equiv="refresh" content="0;url=home.php?procedure=tourguides" />';
 
	 }
 
	/* if ($procedure=="guide_deleteme"){

		$guideuid = $_REQUEST["guideUid"];
		// connecttion, tourgide table, the Record i want to remove, which page after i have deleted
		Delete_A_record($dbConn,"tourguide",$guideUid,"guides");
	
		}*/
 
 if ($procedure=="editme"){
 
	 $uid 	  = $_REQUEST["uid"] ;
	 $fromDB  = $_REQUEST["fromDB"] ;
	 $myerror = ""; // use this for any validation we need!
 
	 if ($fromDB==""){
 
		 $query = "SELECT * FROM tourGuide WHERE uid='".$uid."'";
		 $result = mysqli_query($dbConn, $query);
		 while($Arrayline = mysqli_fetch_assoc($result)) {
			 $fName 	= $Arrayline["guideName"];
			 $lName 	= $Arrayline["guideSurname"];
             $commLevel = $Arrayline["commLevel"];
             $active 	= $Arrayline["active"];
			 }
 
		 }else{
 
			 $fName 	= $_REQUEST["guideName"];
			 $lName 	= $_REQUEST["guideSurname"];
             $commLevel = $_REQUEST["commLevel"];
             $active	= $_REQUEST["active"];
			 }
 

 if ($myerror=="" && $fromDB <> ""){
 
	  $query = "UPDATE tourGuide SET guideName='".addslashes($fName)."',guideSurname='".addslashes($lName)."'commLevel='".addslashes($commLevel)."',active='".$active."' WHERE uid='".$uid."'";
	 $result = mysqli_query($dbConn, $query);
 
	 echo "Record updated successfully...";
 
	 echo '<meta http-equiv="refresh" content="0;url=tourguides.php?procedure=tourguides" />';
 
	 }
 
  }
 

 ?>

 </body>
 
 