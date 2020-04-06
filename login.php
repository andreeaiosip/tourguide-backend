
<?php

session_start();
include('myDBConnection.php');
 
$uid	       = $_REQUEST["uid"];
$password	 = $_REQUEST["password"];
$username	 = $_REQUEST["username"];
 
extract($_POST);

if(isset($submit))
{
   $query=mysqli_query($dbConn,"SELECT * FROM user where username= '$username' and password= '$password'");
   echo $query;
	if(mysqli_num_rows($rs)<1)
	{
		$found="N";
	}
	else
	{
		$_SESSION["login"]=$uid;
	}
}
if (isset($_SESSION["login"]))
{
echo "<h1 align=center>Hye you are sucessfully login!!!</h1>";
exit;
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
               <a href="login.php" class="nav-links" target="_blank"><i class="fa fa-fw fa-user-cog" style='margin-right:5px'></i>LOGIN</a>
            </li>
         </ul>
      </nav>
      <!--End Navbar-->
      <main class="main-contact">
         <h2>LOGIN </h2>
         <div class="container container-form">

        
<div class="floating-box">

<form action="login.php" method="post">


   <label for="username">User Name</label>
   <input type="text" id="username" name="username"><br><br>

   <label for="password">Password</label>
   <input type="password" id="password" name="password"><br><br>
   <input name="submit" type="submit" id="submit" value="Login"><br>


<?php
		  if(isset($found))
		  {
		  	echo '<p class="w3-center w3-text-red">Invalid user id or password<br><a href="login.php">Please try again</p>';
		  }
		  ?>
 
</form>

</div>

            <!-- Helpful code found here: https://www.w3schools.com/html/html_forms.asp 
            <form name="myForm" action="/admin/tours.php" onsubmit="return validateForm()" method="post">
               
               <div>
                  <label for="username">Username</label>
                  <input name="username" type="text" id="username" class="form-control" value="required>
               </div>
               <br>
               <div>
                  <label for="password">Password</label>
                  <input name="password" type="password" id="password" class="form-control" value" required >
               </div>
               <br>
                  <input type="submit" onClick="testEmpty()" value="Submit">
            </form>-->
            </div>
         </div>
      </main>
     
       
      </div>
   </body>
   <script src='https://kit.fontawesome.com/a076d05399.js'></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="./assets/js/app.js"></script>
 
</html>