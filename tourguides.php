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
 <body>
 
 
 
 <div class="navbar">
 <?php
 
 if ($procedure=="home"){
	  $myActivehome = "class='active'";
	 }
 if ($procedure=="tours"){
	  $myActiveTour = "class='active'";
	 }
 if ($procedure=="tourguides"){
	  $myActiveGuide = "class='active'";
	 }
 if ($procedure=="comms"){
	  $myActiveComms = "class='active'";
	 }
 
 if ($procedure=="bookings"){
	  $myActiveBook = "class='active'";
	 }
 
 // For you to code!
 // try and add the Payroll link as the active when you click or select it
 
 
   echo '<a '.  $myActivehome  . 'href="home.php?procedure=home"><i class="fa fa-fw fa-home"></i>Home</a>';
   echo '<a '.  $myActiveTour  . 'href="home.php?procedure=tours"><i class="fa fa-fw fa-search"></i>Tours</a>';
   echo '<a '.  $myActiveGuide . 'href="home.php?procedure=tourguides"><i class="fa fa-fw fa-envelope"></i> Tour Guides</a>';
   echo '<a '.  $myActiveComms . 'href="home.php?procedure=comms"><i class="fa fa-fw fa-envelope"></i> Comms Levels</a>';
   echo '<a '.  $myActiveBook  . 'href="home.php?procedure=bookings"><i class="fa fa-fw fa-envelope"></i> Bookings</a>';
   echo '<a '.  $myActive      . 'href="home.php?procedure=payroll"><i class="fa fa-fw fa-envelope"></i> Payroll</a>';
   echo '<a '.  $myActive      . 'href="home.php?procedure=admin"><i class="fa fa-fw fa-envelope"></i> Admin</a>';
   echo '<a '.  $myActive      . 'href="index.php"><i class="fa fa-fw fa-user"></i> Logout</a>';
 
 ?>
 </div>
 
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
 
	  $query = "INSERT INTO tours (name,description,price) VALUES (".
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
 
 