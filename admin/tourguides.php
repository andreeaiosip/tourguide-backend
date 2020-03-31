<?php
$fName 		= $_REQUEST["guideName"];
$lName 		= $_REQUEST["guideSurname"];
$commLevel  = $_REQUEST["commLevel"];
$active 	= $_REQUEST["active"];



$procedure = $_REQUEST["procedure"] ;
include('myDBConnection.php');


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
 
 if ($procedure=="deleteme"){
 
	 $uid 	   = $_REQUEST["uid"] ;
	 $query    = "DELETE FROM tourGuide WHERE uid='".$uid."'";
	 $result   = mysqli_query($dbConn, $query);
 
	 echo '<meta http-equiv="refresh" content="0;url=home.php?procedure=tourguides" />';
 
	 }
 
 
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
 
	  $query = "UPDATE tourGuide SET guideName='".addslashes($fName)."',guideSurname='".addslashes($lName)."'commLevel='".addslashes($commLevel)."',active='".$active."' WHERE uid='".$tuid."'";
	 $result = mysqli_query($dbConn, $query);
 
	 echo "Record updated successfully...";
 
	 echo '<meta http-equiv="refresh" content="0;url=home.php?procedure=tourguides" />';
 
	 }
 
  }
 

 ?>

 </body>
 
 