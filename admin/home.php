<?php

$procedure = $_REQUEST["procedure"] ;

include('myDBConnection.php');


?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/css/style.css">
<body>

<?php

include('menuTabs.php');


/*echo $procedure;*/


if ($procedure=="home"){
echo '
	<div class="about-section">
	  <h1>Global Tours Payroll System</h1>
	  <p>System to Manage payroll payments for tour guides</p>
	  <p>Integrated with our cities website</p>
	</div>
';

	}

?>
<script src="./assets/js/app.js"></script>
</body>

