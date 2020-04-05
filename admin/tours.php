<?php
$fname 	 = $_REQUEST["customerName"];
$lname	 = $_REQUEST["customerSurname"];
$email	 = $_REQUEST["customerEmail"];
$Pax	 = $_REQUEST["Pax"];
$date 	 = $_REQUEST["dateTour"];
$tours   = $_REQUEST["mytourselected"];
$saveme  = $_REQUEST["saveme"];
$tuid 	 = $_REQUEST["tuid"];
$fromDB  = $_REQUEST["fromDB"] ;
$price 	 = $_REQUEST["price"];
$Tname   = $_REQUEST["TourName"];
$Desc	 = $_REQUEST["Description"];
$fromDB  = $_REQUEST["fromDB"];


$procedure = $_REQUEST["procedure"];
include('myDBConnection.php');
include('deleteFunction.php');

 ?>
 
 <!DOCTYPE html>
 <html>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="../assets/css/style.css">
    
 
 <body>
 

 <?php
 
 include('menuTabs.php');
 
 
 ?>
 </div>
 
 <?php
 
 
 /*echo $procedure;
 
 if ($procedure=="deleteTour"){
 
	 $tuid 	  = $_REQUEST["uid"] ;
 
	 $query    = "DELETE FROM tours WHERE uid='".$tuid."'";
	 $result   = mysqli_query($dbConn, $query);
 
	 echo '<meta http-equiv="refresh" content="0;url=tours.php?procedure=tours" />';
 
	 }
 */

if ($procedure=="deleteTour"){

	
	Delete_A_record($dbConn,"tours",$tuid);

	echo '<meta http-equiv="refresh" content="0;url=tours.php?procedure=tours&showSnack=Record Deleted! successfully..." />';

	}

 // EDIT TOUR------------------------

 if ($procedure=="editTour"){
 
	 //$tuid 	  	= $_REQUEST["tuid"] ;
	
	 //$myerror    = ""; // use this for any validation we need!
 
	 /*if ($fromDB==""){
 
		 $query = "SELECT * FROM tours WHERE uid='".$tuid."'";
		 $result = mysqli_query($dbConn, $query);
	 }*/
 
 

 echo '
	   <form action="tours.php">
	   <input type="hidden" name="procedure" value= '.$procedure.'>
	   <input type="hidden" name="tuid" value='.$tuid.'>
	   <label for="TourName">Tour name:</label><br>
	   <input type="text" id="Tname" name="TourName" required value="'.$Tname.'"><br>
	   <label for="tourDescription">Tour Description:</label><br>
	   <input type="text" id="Desc" size="150" name="Description" required value="'.$Desc.'"><br><br>
	   <label for="tourPrice">Tour Price:</label><br>
	   <input type="number" id="price" name="price" required value="'.$price.'"><br><br>
	   <input type="hidden" name="fromDB" value="no">
	   <input type="submit" value="Submit">
	   </form>';
 
 if ($fromDB <> ""){
 

	$query   = "UPDATE tours SET TourName='".addslashes($Tname)."',Description='".addslashes($Desc)."',Price='".$price."' WHERE uid='".$tuid."'";
	 $result = mysqli_query($dbConn, $query);
 
	 echo "Record updated successfully...";
 
	 echo '<meta http-equiv="refresh" content="0;url=tours.php?procedure=tours" />';
 
	 }
 

  }
 
 
	/*SHOW TOURS ----------------------*/ 
 
 if ($procedure=="tours"){
 
 echo ' <form>
 <table>
   <tr>
	 <th>Tour ID</th>
	 <th>Tour Name</th>
	 <th>Tour Descrip</th>
	 <th>Tour Price</th>
	 <th>Action</th>
   </tr>';
 
	 $query = "SELECT * FROM tours";
	 $result = mysqli_query($dbConn, $query);
	 while($Arrayline = mysqli_fetch_assoc($result)) {
 
	 echo '<tr>';
		  echo '<td>';
		  echo $Arrayline['uid'];
		  echo '</td>';
		  echo '<td name="TourName">'.strtoupper($Arrayline['TourName']).'</td>';
		  echo '<td name="Description">'.ucwords($Arrayline['Description']).'</td>';
		  echo '<td name="price">'.$Arrayline['Price'].'</td>';
		  echo '<td>';
		   echo '<a href="tours.php?procedure=deleteTour&tuid='.$Arrayline['uid'].'" title="This will delete me"><i class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
		   echo '<a href="tours.php?procedure=editTour&tuid='.$Arrayline['uid'].'" title="This will Edit me"><i class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
		  echo '</td>';
		 echo '</tr>';
	 }

   echo '</table>';
   echo '</form>';
   echo '<a href="tours.php?procedure=addnewtour"><i class="fa fa-fw fa-user"></i>Add tour</a>';
 
 
	 }
 
// ADD NEW TOUR------------------
 
 
 if ($procedure=="addnewtour"){
 
 $wasiposted 	= $_REQUEST["wasiposted"] ;
 
 $myerror = "Please complete the below!";
 
 
 if ($wasiposted<> ""){
 
	 if (strlen($Desc) < 15){
 
	   $myerror .= "<br><br><br><BIG><BIG><BIG>Please enter a more comprehensive description</BIG></BIG></BIG>";
 
		 }
 
 }
 
 echo $myerror;
 
 
 
 echo '
   <form action="tours.php">
   <input type="hidden" name="procedure" value= '.$procedure.'>
   <label for="TourName">Tour name:</label><br>
   <input type="text" id="Tname" name="TourName" required value="'.$Tname.'"><br>
   <label for="Description">Tour Description:</label><br>
   <input type="text" id="Desc" size="150" name="Description" required value="'.$Desc.'"><br><br>
   <label for="Price">Tour Price:</label><br>
   <input type="text" id="Price" name="price" required value="'.$price.'"><br><br>
   <input type="hidden" name="wasiposted" value="formposted">
   <input type="submit" value="Submit">
   </form>';
 
 
 if ($wasiposted <> ""){
 
	  $query = "INSERT INTO tours (TourName, Description, Price) VALUES (".
				 "'".$Tname."',".
				 "'".$Desc."',".
				 "'".$price."')";
 
	
	 $result = mysqli_query($dbConn, $query);
 
 
	 echo "Record added successfully...";
 
	 echo '<meta http-equiv="refresh" content="0;url=tours.php?procedure=tours" />';
 
	 }
 
  }

 ?>
 

 </body>
 
 