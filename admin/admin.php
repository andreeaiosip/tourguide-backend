<?php


session_start();

$procedure		 = $_REQUEST["procedure"] ;

  include('myDBConnection.php');
  include('deleteFunction.php');
  include('commonFunctions.php');
  include('/login.php');

?>
<!DOCTYPE html>
 <html>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="../assets/css/style.css">
    
 
 <body>
 

 <?php
 
 include('menuTabs.php');
 echo '<div class="sessionRole">';
 echo '<p>';
 echo 'Logged in as: ' .	$_SESSION["accessRole"];
 echo '</p>';
 echo '</div>';
 
 ?>
 </div>
 
 
<?php

if ($procedure=="commission"){

  echo '<table>
    <tr>
      <th>Commission ID</th>
      <th>Comms Level</th>
      <th>Commission Rate</th>
      <th>Action</th>
    </tr>';
  
    $query = "SELECT * FROM commLevel";
    $result = mysqli_query($dbConn, $query);
    while($Arrayline = mysqli_fetch_assoc($result)) {
  
      echo '<tr>';
         echo '<td>';
           echo $Arrayline['uid'];
       echo '</td>';
       echo '<td>'.ucwords($Arrayline['commDescription']).'</td>';
  
       if ($Arrayline['commPercent'] > 0 ) {
         echo '<td>'.$Arrayline['commPercent'].'% </td>';
       }else {
         echo '<td bgcolor="orange"><big>Please edit and update me</big></td>';
         }
  
  
       echo '<td>';
        echo '<a href="commission.php?procedure=deleteComm&cuid='.$Arrayline['uid'].'" title="Delete me"><i style="color:#323232bf" class="fa fa-trash fa fa-2x" aria-hidden="true"></i></a>';
        echo '<a href="commission.php?procedure=editComm&cuid='.$Arrayline['uid'].'" title="Edit me"><i style="color:#323232bf" class="fa fa-pencil-square fa-2x" aria-hidden="true"></i></a>';
       echo '</td>';
      echo '</tr>';
  
  
  
    }
  
    echo '</table>';
  
  
    //echo '<a href="commission.php?procedure=addCommLevel"><i class="fa fa-fw fa-plus fa-2x"></i>NEW</a>';
      //echo '<button class="btn success"><a href="commission.php?procedure=editComm"><i class="fa fa-handshake-o fa-lg" aria-hidden="true"></i> Edit Commission Level</a></button>';
    echo '<button class="btn success" style="border-radius:4px"><a href="commission.php?procedure=addCommLevel" style="text-decoration:none"><i class="fa fa-handshake-o fa-2x" aria-hidden="true"></i> NEW</a></button>';
    
  
    
  
      //echo '<a href="commission.php?procedure=addnewcommlevel"><i class="fa fa-fw fa-plus fa-2x"></i>Add Commission Level</a>';
     // echo '<button class="btn success"><a href="commission.php?procedure=addnewcommlevel"><i class="fa fa-handshake-o fa-lg" aria-hidden="true"></i> Add Commission Level</a></button>';
  
  
    }

?>
    </body>

    </html>
