<?php

include('admin/myDBConnection.php');
//include('admin/deleteFunction.php');
//include('admin/commonFunctions.php');

$bookguid= $_REQUEST["guid"];
$fname   = $_REQUEST["customerName"];
$lname   = $_REQUEST["customerSurname"];
$email   = $_REQUEST["customerEmail"];
$Pax     = $_REQUEST["Pax"];
$date    = $_REQUEST["dateTour"];
$tours   = $_REQUEST["TourName"];
$saveme  = $_REQUEST["saveme"];



$tours      = $_REQUEST["tours"];
$tourguide  = $_REQUEST["tourGuide"];
$saveme     = $_REQUEST["saveme"];


// field of db
if ($tours=="NONE"){
	echo "Please select a tour to attend!";
	$saveme = "";
   }
   
if ($saveme=="yesplease"){
	$bookid = "BkRef:".generateRandomString(4);
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
											"'".addslashes($sname)."',".
											"'".addslashes($fname)."',".
											"'".addslashes($email)."')";

	 $myResult=mysqli_query($dbConn,$myBookingSql);
	 if ($myResult) {
	    echo "New record created successfully<hr>";
         echo '<meta http-equiv="refresh" content="0;url=../thankyou.php?myBookid='.$bookid.'&myName='.$fname.'">';
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
            <form name="myForm" action="tourBooking.php" onsubmit="return validateForm()" method="post">
               <label for="fname">First Name</label>
               <input type="text" name="fname" id="firstname" autofocus required placeholder="Your first name..">
               <label for="lname">Last Name</label>
               <input type="text" name="lastname" id="lname" required placeholder="Your last name..">
               <div>
                  <label for="telephone">Phone number</label>
                  <input type="tel" name="tel" required placeholder="Your phone number">
               </div>
               <div>
                  <label for="email">Email address</label>
                  <input type="email"  name="email" id="email" required placeholder="Your email address">
               </div>
               <br>
               <div>
               <br>
               <label for="query">Select a tour:</label>
               <select id="query">

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
                  <input type="number" min="1" step="1" required>
               </div>
               <br>
               <div class="people">
                  <label for="people">Date of the tour:</label>
                  <input type="date" id="inputDate" name="trip-start"
                     value="2020-01-26"
                     min="2020-01-26">
                     </div>
                  <br>
                  <br>
                 
                  <input type="hidden" name="saveme" value="yesplease">
                  

                   <input type="submit" onClick="testEmpty()" value="Submit">
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