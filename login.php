<?php

session_start();

include('admin/myDBConnection.php');

$action = $_REQUEST["action"];

if ($action == "logout") {
    session_unset();
}


?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="./assets/css/indexstyle.css">
    
 
<body>
   <nav class="navbar">
          <span class="navbar-toggle" id="js-navbar-toggle">
          <i class="fas fa fa-bars"></i>
          </span>
          <a href="#" class="logo grow">BRASOV CITY</a>
          <ul class="main-nav" id="js-menu">
            <li>
               <a href="index.html" class="nav-links"><i class="fa fa-fw fa-lg fa-home"></i>HOME</a>
            </li>
            <li>
               <a href="tourBooking.php" class="nav-links"><i class="fas fa-bus" style='margin-right:5px'></i>TOURS</a>
            </li>
            <li>
               <a href="login.php" class="nav-links"><i class="fa fa-fw fa-user-cog" style='margin-right:5px'></i>LOGIN</a>
            </li>
          </ul>
       </nav>
<center>
<?php


$uname              = $_REQUEST["uname"];
$upass              = $_REQUEST["upass"];
$wasaloginattempted = $_REQUEST["wasaloginattempted"];
$mymessage          = "";

if ($wasaloginattempted == "yes") {
    
    $_SESSION["User_ID"] = "";
    
    $query = "SELECT *,user.uid AS USERuid
                    FROM user
                    LEFT JOIN tourGuide ON tourGuide.uid = user.tourGuideUid
                    WHERE user.username='" . $uname . "' AND user.password='" . $upass . "'";
    
    
    $result = mysqli_query($dbConn, $query);
    while ($ArrayofUserinfo = mysqli_fetch_assoc($result)) {
        $_SESSION["User_ID"]    = $ArrayofUserinfo["USERuid"];
        $_SESSION["User_Name"]  = $ArrayofUserinfo["username"];
        $_SESSION["accessRole"] = $ArrayofUserinfo["accessRole"];
        $_SESSION["TG_uid"]     = $ArrayofUserinfo["tourGuideUid"];
        $_SESSION["TG_name"]    = $ArrayofUserinfo["guideName"];
        
    }
    
    
    if ($_SESSION["User_ID"] <> "") {
        if ($_SESSION["accessRole"] == "Adm") {
            echo '<meta http-equiv="refresh" content="0;url=admin/tours.php?procedure=tours" />';
        } else {
            echo '<meta http-equiv="refresh" content="0;url=admin/bookings.php?procedure=bookings" />';
        }
    } else {
        $uname     = "";
        $upass     = "";
        $mymessage = "Your username or password are not correct. Please try again.";
    }
    
}





echo '<div class=" container container-form">';
echo '<form  action="login.php" method="post">';

echo '<label for="uname">User Name:</label><br>';
echo '      <input type="text" id="uname" name="uname" size="5" required value="' . $uname . '"><br>';
echo '<label for="password">Password:</label><br>';
echo '      <input type="text" id="upass" size="5" name="upass" required value="' . $upass . '"><br><br>';
echo '      <input type="hidden" name="wasaloginattempted" value="yes">';
echo '      <input type="submit" value="LOGIN">';
echo '    </form>';
echo '<div>
<br>
<br>';
echo $mymessage;
?>


</center>

    </body>
   <script src='https://kit.fontawesome.com/a076d05399.js'></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="./assets/js/app.js"></script>
</html>