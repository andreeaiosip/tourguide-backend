<?php

include('admin/myDBConnection.php');
//include('admin/deleteFunction.php');
//include('admin/commonFunctions.php');

$bookguid= $_REQUEST["guid"];
$fname   = $_REQUEST["fname"];
$lname   = $_REQUEST["lname"];
$email   = $_REQUEST["email"];
$Pax     = $_REQUEST["Pax"];
$date    = $_REQUEST["trip-start"];
$tours   = $_REQUEST["query"];
$addrecord  = $_REQUEST["addrecord"]; //saveme



// field of db
if ($tours=="NONE"){
	echo "Please select a tour to attend!";
	$addrecord = "";
   }
   
 if ($addrecord=="confirmRecord"){
	$bookid = "BkRef:".rand(1000,9999);
    //$myNewDBguid = guid();
    $bookguid = "GuidREF-".rand(20, 45);
    //https://www.php.net/manual/en/function.com-create-guid.php
    //INSERT INTO bookings (bookid,numOfPeoples) VALUES ('4','3');
    
    //$myBookingSql = "SELECT *,bookings.uid AS bookingID_fromDB
    //		FROM bookings
    //  	LEFT JOIN tours ON tours.guid = bookings.toursguid 
	//	 	LEFT JOIN tourguide ON tourguide.guid = bookings.tourguideguid";
    
	$myBookingSql = "INSERT INTO bookings (guid,bookref,tourUid,Pax,dateTour,
												tourGuideUid,customerName,customerSurname,
												customerEmail) 
                                    VALUES (".
         							   "'".$bookguid."',".
                                 "'".$bookid."',".
                                 "'".$tours."',".
											"'".$Pax."',".
											"'".$date."',".
        								   "'".$tourguide."',".
											"'".addslashes($fname)."',".
											"'".addslashes($lname)."',".
											"'".addslashes($email)."')";
   echo $myBookingSql;
   $myResult=mysqli_query($dbConn,$myBookingSql);
	if ($myResult) {
	    echo "New record created successfully<hr>";
         //echo '<meta http-equiv="refresh" content="0;url=../thankyou.php?myBookid='.$bookid.'&myName='.$fname.'">';
	 } else {
	    echo "Error: " . $myBookingSql . " <hr> " . mysqli_error($dbConn);
         die;
	 }
 
}


?>



<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="./assets/css/indexstyle.css">
      <style>
         h2 {
         text-align: center;
         }
         .fa, .fa-fw, .fa-lg, .fa-home {
         margin-right:5px;
         }
      </style>
      <title>Brasov City</title>
   </head>
   <body>
      <nav class="navbar">
         <span class="navbar-toggle" id="js-navbar-toggle">
            <i class="fas fa fa-bars"></i>
            </span>
         <a href="index.html" class="logo grow">BRASOV CITY</a>
         <ul class="main-nav" id="js-menu">
            <li>
               <a href="index.html" class="nav-links"><i class="fa fa-fw fa-lg fa-home"></i>HOME</a>
            </li>
            
            <li>
               <a href="tourBooking.php" class="nav-links" target="_blank"><i class="fas fa-bus" style='margin-right:5px'></i>TOURS</a>
            </li>
          
            <li>
               <a href="login.html" class="nav-links" target="_blank"><i class="fa fa-fw fa-user-cog" style='margin-right:5px'></i>LOGIN</a>
            </li>
         </ul>
      </nav>
      <!--End Navbar-->
      <main class="main-contact">
         <h2> BOOK A TOUR WITH US </h2>
         <div class="container container-form">
            <!-- Helpful code found here: https://www.w3schools.com/html/html_forms.asp -->
            <form name="myForm" action="tourBooking.php" onsubmit="return validateForm()">
               <label for="fname">First Name</label>
               <input type="text" name="fname" id="firstname" autofocus required placeholder="Your first name..">
               <label for="lname">Last Name</label>
               <input type="text" name="lname" id="lastname" required placeholder="Your last name..">
               <div>
                  <label for="email">Email address</label>
                  <input type="email"  name="email" id="email" required placeholder="Your email address">
               </div>
               <br>
               <div>
               <br>
               <label for="query">Select a tour:</label>
               <select id="query" name="query">

<?php




$query = "SELECT * FROM tours";
$result = mysqli_query($dbConn, $query);
while($Arrayline = mysqli_fetch_assoc($result)) {

   echo "<option value=".$Arrayline["uid"].">".$Arrayline["TourName"]."</option>";

}


?>
   </select>

                  
            
              
               <br>
               <div class="people">
                  <label for="people">Number of people:</label>
                  <input type="number" name="Pax" min="1" step="1" required>
               </div>
               <br>
               <div class="people">
                  <label for="people">Date of the tour:</label>
                  <input type="date" value="<?php echo date('Y-m-d'); ?>" />
                     </div>
                  <br>
                  <br>
                 
                  <input type="hidden" name="addrecord" value="confirmRecord">
                  

                   <input type="submit" onClick="testEmptyt()" value="Submit">
            </form>
            </div>
         </div>
      </main>
     
       
      </div>
   </body>
   <script src='https://kit.fontawesome.com/a076d05399.js'></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="./assets/js/app.js"></script>
 
</html>