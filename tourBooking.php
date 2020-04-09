<?php

session_start();
include('admin/myDBConnection.php');
//include('admin/deleteFunction.php');
//include('admin/commonFunctions.php');

$bookguid= $_REQUEST["guid"];
$fname   = $_REQUEST["fname"];
$lname   = $_REQUEST["lname"];
$email   = $_REQUEST["email"];
$Pax     = $_REQUEST["Pax"];
$date    = $_REQUEST["date"];
$tours   = $_REQUEST["query"];
$addrecord  = $_REQUEST["addrecord"]; 




if ($tours=="NONE"){
	echo "Please select a tour to attend!";
	$addrecord = "";
   }
   
 if ($addrecord=="confirmRecord"){
	$bookid = "BkRef".rand(1000,9999);
 
    $bookguid = bin2hex(random_bytes(16));
    //https://www.php.net/manual/en/function.com-create-guid.php

    
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
  
   $myResult=mysqli_query($dbConn,$myBookingSql);
	if ($myResult) {
	   echo "Thank you for your booking<hr>";
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
               <a href="tourBooking.php" class="nav-links" ><i class="fas fa-bus" style='margin-right:5px'></i>TOURS</a>
            </li>
            <li>
               <a href="login.php" class="nav-links"><i class="fa fa-fw fa-user-cog" style='margin-right:5px'></i>LOGIN</a>
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
                 <br>
                  <label for="query">Select a tour:</label>
                  <select id="query" name="query">
                     <?php
                        $query = "SELECT * FROM tours";
                        $result = mysqli_query($dbConn, $query);
                        while($Arrayline = mysqli_fetch_assoc($result)) 
                        {
                        echo "<option value=".$Arrayline["uid"].">".$Arrayline["TourName"]."</option>";
                        //echo "<OPTION value='NONE'>NONE SELECTED</OPTION>\n";
                        }
                     ?>
                  </select>
                     <br>
                     <div class="Pax">
                        <label for="Pax">Number of people:</label>
                        <input type="number" name="Pax" min="1" step="1" required>
                     </div>
                  <br>
                  <div class="date">
                        <label for="date">Date of the tour:</label>
                        <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" />
                  </div>
                     <br>
                     <br>
                     <input type="hidden" name="addrecord" value="confirmRecord">
                     <input type="submit" onClick="testEmptyt()" value="Submit">
               </form>
            </div>
      </main>
   </body>
   <script src='https://kit.fontawesome.com/a076d05399.js'></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="./assets/js/app.js"></script>
</html>
