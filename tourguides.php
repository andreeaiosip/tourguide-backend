<?php
$pFname = $_REQUEST["guideName"];
$pLname = $_REQUEST["guideSurname"];
$pCommLevel = $_REQUEST["commLevel"];
$pActive = $_REQUEST["active"];



$procedure = $_REQUEST["procedure"] ;
include('myDBConnection.php');


 ?>
 
 <!DOCTYPE html>
 <html>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="./assets/css/style.css">
 <body>
 
 
 
 
 <?php
 
 include('menuTabs.php');
 ?>
 
 
 <?php
 
 
 echo $procedure;
 
 if ($procedure=="deleteme"){
 
	 $pUid 	  = $_REQUEST["uid"] ;
 
	 $query    = "DELETE FROM tourGuide WHERE uid='".$pUid."'";
	 $result   = mysqli_query($dbConn, $query);
 
	 echo '<meta http-equiv="refresh" content="0;url=home.php?procedure=tours" />';
 
	 }
 
 
 if ($procedure=="editme"){
 
	 $pUid 	  	= $_REQUEST["uid"] ;
	 $fromDB 	= $_REQUEST["fromDB"] ;
	 $myerror    = ""; // use this for any validation we need!
 
	 if ($fromDB==""){
 
		 $query = "SELECT * FROM tourGuide WHERE uid='".$pUid."'";
		 $result = mysqli_query($dbConn, $query);
		 while($Arrayline = mysqli_fetch_assoc($result)) {
			 $pFname = $Arrayline["guideName"];
			 $pLname  = $Arrayline["guideSurname"];
             $pCommLevel = $Arrayline["commLevel"];
             $pActive = $Arrayline["active"];
			 }
 
		 }else{
 
			 $pFname = $_REQUEST["guideName"];
			 $pLname = $_REQUEST["guideSurname"];
             $pCommLevel = $_REQUEST["commLevel"];
             $pActive = $_REQUEST["active"];
			 }
 
 
 
 
 

 
 
 
 if ($myerror=="" && $fromDB <> ""){
 
	  $query = "UPDATE tourGuide SET name='".addslashes($pTname)."',description='".addslashes($Desc)."',price='".$price."' WHERE uid='".$tuid."'";
	 $result = mysqli_query($dbConn, $query);
 
	 echo "Record updated successfully...";
 
	 echo '<meta http-equiv="refresh" content="0;url=home.php?procedure=tours" />';
 
	 }
 
 
 
  }
 

 
 
 
 
 
 ?>
 
 
 
 
 </body>
 
 