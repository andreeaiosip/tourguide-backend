<?php
$fname = $_REQUEST["customerName"];
$lname = $_REQUEST["customerSurname"];
$email = $_REQUEST["customerEmail"];
$Pax = $_REQUEST["Pax"];
$date = $_REQUEST["dateTour"];
$tours = $_REQUEST["mytourselected"];
$saveme = $_REQUEST["saveme"];


$procedure = $_REQUEST["procedure"] ;
include('myDBConnection.php');

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
 
 
 echo $procedure;
 
 if ($procedure=="deleteme"){
 
	 $tuid 	  = $_REQUEST["tuid"] ;
 
	 $query    = "DELETE FROM tours WHERE uid='".$tuid."'";
	 $result   = mysqli_query($dbConn, $query);
 
	 echo '<meta http-equiv="refresh" content="0;url=home.php?procedure=tours" />';
 
	 }
 
 
 if ($procedure=="editme"){
 
	 $tuid 	  	= $_REQUEST["tuid"] ;
	 $fromDB 	= $_REQUEST["fromDB"] ;
	 $myerror    = ""; // use this for any validation we need!
 
	 if ($fromDB==""){
 
		 $query = "SELECT * FROM tours WHERE uid='".$tuid."'";
		 $result = mysqli_query($dbConn, $query);
		 while($Arrayline = mysqli_fetch_assoc($result)) {
			 $Tname = $Arrayline["TourName"];
			 $Desc  = $Arrayline["Description"];
			 $price = $Arrayline["Price"];
			 }
 
		 }else{
 
			 $Tname = $_REQUEST["Tname"];
			 $Desc  = $_REQUEST["Desc"];
			 $price = $_REQUEST["price"];
			 }
 
 
 
 
 
 
 echo '
	   <form action="home.php?procedure='.$procedure.'&tuid='.$tuid.'" method="post">
	   <label for="fname">Tour name:</label><br>
	   <input type="text" id="Tname" name="Tname" required value="'.$Tname.'"><br>
	   <label for="lname">Tour Description:</label><br>
	   <input type="text" id="Desc" size="150" name="Desc" required value="'.$Desc.'"><br><br>
	   <label for="lname">Tour Price:</label><br>
	   <input type="number" id="price" name="price" required value="'.$price.'"><br><br>
	   <input type="hidden" name="fromDB" value="no">
	   <input type="hidden" name="who" value="miro">
	   <input type="submit" value="Submit">
	   </form>';
 
 
 
 if ($myerror=="" && $fromDB <> ""){
 
	  $query = "UPDATE tours SET name='".addslashes($Tname)."',description='".addslashes($Desc)."',price='".$price."' WHERE uid='".$tuid."'";
	 $result = mysqli_query($dbConn, $query);
 
	 echo "Record updated successfully...";
 
	 echo '<meta http-equiv="refresh" content="0;url=home.php?procedure=tours" />';
 
	 }
 
 
 
 
 
 
  }
 
 
	 
 
 if ($procedure=="tours"){
 
 echo '<table>
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
		  echo '<td>'.strtoupper($Arrayline['TourName']).'</td>';
		  echo '<td>'.ucwords($Arrayline['Description']).'</td>';
		  echo '<td>'.$Arrayline['Price'].'</td>';
		  echo '<td>';
		   echo '<a href="home.php?procedure=deleteme&tuid='.$Arrayline['uid'].'" title="This will delete me"><i class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
		   echo '<a href="home.php?procedure=editme&tuid='.$Arrayline['uid'].'" title="This will Edit me"><i class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
		  echo '</td>';
		 echo '</tr>';
 
 
 
	 }
 
   echo '</table>';
 
 
   echo '<a href="home.php?procedure=addnewtour"><i class="fa fa-fw fa-user"></i>Add tour</a>';
 
 
	 }
 
 
 
 
 if ($procedure=="addnewtour"){
 
 $Tname 		= $_REQUEST["TourName"] ;
 $Desc  		= $_REQUEST["Description"] ;
 $price 		= $_REQUEST["Price"] ;
 $wasiposted = $_REQUEST["wasiposted"] ;
 
 $myerror = "Please complete the below!";
 
 
 if ($wasiposted<> ""){
 
	 if (strlen($Desc) < 15){
 
	   $myerror .= "<br><br><br><BIG><BIG><BIG>Please enter a more comprehensive description</BIG></BIG></BIG>";
 
		 }
 
 }
 
 echo $myerror;
 
 
 
 echo '
   <form action="home.php?procedure='.$procedure.'" method="post">
   <label for="fname">Tour name:</label><br>
   <input type="text" id="Tname" name="TourName" required value="'.$Tname.'"><br>
   <label for="lname">Tour Description:</label><br>
   <input type="text" id="Desc" size="150" name="Description" required value="'.$Desc.'"><br><br>
   <label for="lname">Tour Price:</label><br>
   <input type="number" id="price" name="Price" required value="'.$price.'"><br><br>
   <input type="hidden" name="wasiposted" value="formposted">
   <input type="submit" value="Submit">
   </form>';
 
 
 if ($myerror=="" && $wasiposted <> ""){
 
	  $query = "INSERT INTO tours (TourName,Description,Price) VALUES (".
				 "'".$Tname."',".
				 "'".$Desc."',".
				 "'".$price."')";
 
	 $result = mysqli_query($dbConn, $query);
 
 
	 echo "Record added successfully...";
 
	 echo '<meta http-equiv="refresh" content="0;url=home.php?procedure=tours" />';
 
	 }
 
 
 
 
 
 
 
 
 
  }
 
 
 
 
 ?>
 
 
 
 
 </body>
 
 