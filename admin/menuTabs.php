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
if ($procedure=="commission"){
	 $myActiveComms = "class='active'";
	}

if ($procedure=="bookings"){
	 $myActiveBook = "class='active'";
    }
    
if ($procedure=="payroll"){
        $myActivePayroll = "class='active'";
       }

// For you to code!
// try and add the Payroll link as the active when you click or select it

echo '<div class="navbar">';
  echo '<a '.  $myActivehome    . 'href="home.php?procedure=home"><i class="fa fa-fw fa-home"></i> HOME</a>';
  echo '<a '.  $myActiveTour    . 'href="tours.php?procedure=tours"><i class="fa fa-fw fa-search"></i> TOURS</a>';
  echo '<a '.  $myActiveGuide   . 'href="tourguides.php?procedure=tourguides"><i class="fa fa-user-circle-o" aria-hidden="true"></i> TOUR GUIDES</a>';
  echo '<a '.  $myActiveComms   . 'href="commission.php?procedure=commission"><i class="fa fa-handshake-o" aria-hidden="true"></i> COMM LEVEL</a>';
  echo '<a '.  $myActiveBook    . 'href="bookings.php?procedure=bookings"><i class="fa fa-book" aria-hidden="true"></i> BOOKINGS</a>';
  echo '<a '.  $myActivePayroll . 'href="payroll.php?procedure=payroll"><i class="fa fa-money" aria-hidden="true"></i></i> PAYROLL</a>';
  echo '<a '.  $myActiveAdmin   . 'href="plsremembertoaddme.php?procedure=admin"><i class="fa fa-fw fa-user"></i> ADMIN</a>';
  echo '<a '.  $myActiveLogout  . 'href="index.php"><i class="fa fa-lock" aria-hidden="true"></i> LOGOUT</a>';
echo '</div><br>';
//echo "<hr>";
//echo '<div class="headerBar" align="right"><span class="label success"><i class="fa fa-map-signs" aria-hidden="true"></i> Your are here |  '.strtoupper($procedure).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div><br>';


?>