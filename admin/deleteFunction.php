<?php

function Delete_A_record($dbConn,$Tablenamed,$recordID){

	$query    = "DELETE FROM ".$Tablenamed." WHERE uid='".$recordID."'";
	echo $query;
	$result   = mysqli_query($dbConn, $query);
    echo '<meta http-equiv="refresh" content="0;url=home.php?procedure=tours&showSnack=Record Deleted! successfully..." />';
	}



?>