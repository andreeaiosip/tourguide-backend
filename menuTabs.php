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
  echo '<a '.  $myActivehome  . 'href="home.php?procedure=home"><i class="fa fa-fw fa-home"></i> Home</a>';
  echo '<a '.  $myActiveTour  . 'href="home.php?procedure=tours"><i class="fa fa-fw fa-search"></i> Tours</a>';
  echo '<a '.  $myActiveGuide . 'href="home.php?procedure=tourguides"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Tour Guides</a>';
  echo '<a '.  $myActiveComms . 'href="commision.php?procedure=commission"><i class="fa fa-handshake-o" aria-hidden="true"></i> Comms Levels</a>';
  echo '<a '.  $myActiveBook  . 'href="home.php?procedure=bookings"><i class="fa fa-book" aria-hidden="true"></i> Bookings</a>';
  echo '<a '.  $myActivePayroll . 'href="home.php?procedure=payroll"><i class="fa fa-money" aria-hidden="true"></i></i> Payroll</a>';
  echo '<a '.  $myActiveAdmin  . 'href="home.php?procedure=admin"><i class="fa fa-fw fa-user"></i> Admin</a>';
  echo '<a '.  $myActiveLogout . 'href="index.php"><i class="fa fa-lock" aria-hidden="true"></i> Logout</a>';
echo '</div><br>';
//echo "<hr>";
echo '<div class="headerBar" align="right"><span class="label success"><i class="fa fa-map-signs" aria-hidden="true"></i> Your are here |  '.strtoupper($procedure).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div><br>';


?>