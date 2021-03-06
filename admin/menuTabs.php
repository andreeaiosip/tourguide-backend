<?php


if ($procedure == "tours") {
    $myActiveTour = "class='active'";
}
if ($procedure == "tourguides") {
    $myActiveGuide = "class='active'";
}
if ($procedure == "commission") {
    $myActiveComms = "class='active'";
}

if ($procedure == "bookings") {
    $myActiveBook = "class='active'";
}

if ($procedure == "payroll") {
    $myActivePayroll = "class='active'";
}

if ($procedure == "admin") {
    $myActiveAdmin = "class='active'";
}

if ($procedure == "logout") {
    $myActiveLogout = "class='active'";
}

echo '<div class="navbar">';
if ($_SESSION["accessRole"] == "Adm") {
    echo '<a ' . $myActiveTour    . 'href="tours.php?procedure=tours"><i class="fa fa-fw fa-bus"></i> TOURS</a>';
    echo '<a ' . $myActiveGuide   . 'href="tourguides.php?procedure=tourguides"><i class="fa fa-user-circle-o" aria-hidden="true"></i> TOUR GUIDES</a>';
    echo '<a ' . $myActiveComms   . 'href="commission.php?procedure=commission"><i class="fa fa-handshake-o" aria-hidden="true"></i> COMM LEVEL</a>';
    echo '<a ' . $myActiveBook    . 'href="bookings.php?procedure=bookings"><i class="fa fa-book" aria-hidden="true"></i> BOOKINGS</a>';
    echo '<a ' . $myActivePayroll . 'href="myPayroll.php?procedure=genpayroll"><i class="fa fa-money" aria-hidden="true"></i></i> PAYROLL</a>';
    echo '<a ' . $myActiveAdmin   . 'href="admin.php"><i class="fa fa-fw fa-user"></i> ADMIN</a>';
    echo '<a href="HelpDocAdmin.pdf" target="_blank"><i class="fa fa-question-circle" aria-hidden="true"></i> HELP</a>';
    
} else {
    echo '<a ' . $myActiveBook    . 'href="bookings.php?procedure=bookings"><i class="fa fa-book" aria-hidden="true"></i> BOOKINGS</a>';
    echo '<a ' . $myActivePayroll . 'href="myPayroll.php?procedure=genpayroll"><i class="fa fa-money" aria-hidden="true"></i></i> PAYROLL</a>';
    echo '<a href="HelpDocTourGuide.pdf" target="_blank"><i class="fa fa-question-circle" aria-hidden="true"></i> HELP</a>';  
}

echo '<a ' . $myActiveLogout . 'href="/login.php"><i class="fa fa-lock" aria-hidden="true"></i> LOGOUT</a>';
echo '</div><br>';


?>