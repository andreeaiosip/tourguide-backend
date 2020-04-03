<?php


echo '<div class="navbar">';

if ($_SESSION["AccessRole"]=="Admin"){
  echo '<a '.  $myActivehome    . 'href="home.php?procedure=home"><i class="fa fa-fw fa-home"></i> HOME</a>';
  echo '<a '.  $myActiveTour    . 'href="tours.php?procedure=tours"><i class="fa fa-fw fa-search"></i> TOURS</a>';
  echo '<a '.  $myActiveGuide   . 'href="tourguides.php?procedure=tourguides"><i class="fa fa-user-circle-o" aria-hidden="true"></i> TOUR GUIDES</a>';
  echo '<a '.  $myActiveComms   . 'href="commission.php?procedure=commission"><i class="fa fa-handshake-o" aria-hidden="true"></i> COMM LEVEL</a>';
  echo '<a '.  $myActiveSetup    . 'href="systemSetup.php?procedure=systemSetup"><i class="fa fa-book" aria-hidden="true"></i> ADMIN</a>';
  echo '<a '.  $myActiveBook    . 'href="bookings.php?procedure=bookings"><i class="fa fa-book" aria-hidden="true"></i> BOOKINGS</a>';
  echo '<a '.  $myActivePayroll . 'href="payroll.php?procedure=payroll"><i class="fa fa-money" aria-hidden="true"></i></i> PAYROLL</a>';
  echo '<a '.  $myActiveLogout  . 'href="index.php"><i class="fa fa-lock" aria-hidden="true"></i> LOGOUT</a>';
  echo "<span class='userAccess'>&nbsp;&nbsp;&nbsp;&nbsp;Admin Session</span>";

} else {

    echo '<a '.  $myActivehome    . 'href="home.php?procedure=home"><i class="fa fa-fw fa-home"></i> HOME</a>';
    echo '<a '.  $myActiveBook    . 'href="bookings.php?procedure=bookings"><i class="fa fa-book" aria-hidden="true"></i> BOOKINGS</a>';
    echo '<a '.  $myActivePayroll . 'href="payroll.php?procedure=payroll"><i class="fa fa-money" aria-hidden="true"></i></i> PAYROLL</a>';
    echo '<a '.  $myActiveLogout  . 'href="index.php"><i class="fa fa-lock" aria-hidden="true"></i> LOGOUT</a>';
    //echo "<span class='userAccess'>&nbsp;&nbsp;&nbsp;&nbsp;TG Session(.$_SESSION["TG_name"].)</span>";

}
echo '<img src="C:\tourguide-backend\assets\img\admin.png">';
echo '</div><br>';
//echo "<hr>";
echo '<div class="headerBar" align="right"><span class="label success"><i class="fa fa-map-signs" aria-hidden="true"></i> Your are here |  '.strtoupper($procedure).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div><br>';


?>