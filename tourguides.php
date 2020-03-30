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
 
 
 
 
 
 
 echo '
	   <form action="home.php?procedure='.$procedure.'&tuid='.$tuid.'" method="post">
	   <label for="fname">Tour name:</label><br>
	   <input type="text" id="Tname" name="Tname" required value="'.$Tname.'"><br>
	   <label for="lname">Tour Description:</label><br>
	   <input type="text" id="Desc" size="150" name="Desc" required value="'.$Desc.'"><br><br>
	   <label for="lname">Tour Price:</label><br>
	   <input type="number" id="price" name="price" required value="'.$price.'"><br><br>
	   <input type="hidden" name="fromDB" value="no">
	   <input type="hidden" name="whoistheoldfart" value="miro">
	   <input type="submit" value="Submit">
	   </form>';
 
 
 
 if ($myerror=="" && $fromDB <> ""){
 
	  $query = "UPDATE tourGuide SET name='".addslashes($pTname)."',description='".addslashes($Desc)."',price='".$price."' WHERE uid='".$tuid."'";
	 $result = mysqli_query($dbConn, $query);
 
	 echo "Record updated successfully...";
 
	 echo '<meta http-equiv="refresh" content="0;url=home.php?procedure=tours" />';
 
	 }
 
 
 
 
 
 
  }
 
 
 if ($procedure=="home"){
 echo '
	 <div class="about-section">
	   <h1>Global Tours Payroll System</h1>
	   <p>System to Manage payroll payments for tour guides</p>
	   <p>Integrated with our cities website</p>
	 </div>
 ';
 
 
	 }
 
 if ($procedure=="tours"){
 
 echo '<table>
   <tr>
	 <th>Guide Name</th>
	 <th>Guide Surname</th>
	 <th>Guide Comm Level</th>
	 <th>Active</th>
	 <th>Action</th>
   </tr>';
 
	 $query = "SELECT * FROM tours";
	 $result = mysqli_query($dbConn, $query);
	 while($Arrayline = mysqli_fetch_assoc($result)) {
 
		 echo '<tr>';
		  echo '<td>';
			  echo $Arrayline['uid'];
		  echo '</td>';
		  echo '<td>'.strtoupper($Arrayline['guideName']).'</td>';
		  echo '<td>'.ucwords($Arrayline['guideSurname']).'</td>';
          echo '<td>'.$Arrayline['commLevel'].'</td>';
          echo '<td>'.$Arrayline['active'].'</td>';
		  echo '<td>';
		   echo '<a href="home.php?procedure=deleteme&tuid='.$Arrayline['uid'].'" title="This will delete me"><i class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
		   echo '<a href="home.php?procedure=editme&tuid='.$Arrayline['uid'].'" title="This will Edit me"><i class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
		  echo '</td>';
		 echo '</tr>';
 
 
 
	 }
 
   echo '</table>';
 
 
   echo '<a href="home.php?procedure=addnewtour"><i class="fa fa-fw fa-user"></i>Add tour</a>';
 
 
	 }
 
 
 if ($procedure=="bookings"){
 
 
 echo '<table>
   <tr>
	 <th>Guide Name</th>
	 <th>Guide Surname</th>
	 <th>Comission Level</th>
	 <th>Active</th>
   </tr>';
 
	 $query = "SELECT *
				 FROM bookings
				 LEFT JOIN tours ON tours.uid = bookings.touruid ";
	 $result = mysqli_query($dbConn, $query);
	 while($Arrayline = mysqli_fetch_assoc($result)) {
 
		  echo '<tr>
			
			 <td>'.$Arrayline['guideName']." ".$Arrayline['guideSurname'].'</td>
			 <td>'.$Arrayline['commLevel'].'</td>
			 <td>'.$Arrayline['active'].'</td>
		   </tr>';
 
 
 
	 }
 
   echo '</table>';
 
 
 
	 }
 
 
 if ($procedure=="addnewtour"){
 
 $Tname 		= $_REQUEST["Tname"] ;
 $Desc  		= $_REQUEST["Desc"] ;
 $price 		= $_REQUEST["price"] ;
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
   <input type="text" id="Tname" name="Tname" required value="'.$Tname.'"><br>
   <label for="lname">Tour Description:</label><br>
   <input type="text" id="Desc" size="150" name="Desc" required value="'.$Desc.'"><br><br>
   <label for="lname">Tour Price:</label><br>
   <input type="number" id="price" name="price" required value="'.$price.'"><br><br>
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
 
 