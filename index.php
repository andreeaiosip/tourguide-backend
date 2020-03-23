<?php

$Name = "My name is Andreea";
$myAge = 35;

echo "Hello World ".$Name . ".<HR>";
$myResult = $myAge - 7;
$myPrice = 10.50;
//$myVAT = $myPrice *0.28;

function CalcmyVat($myFPrice, $VatFRate){
   
    $result = $myFPrice * $VatFRate;
    return $result;

}

$myVAT = CalcmyVat($myPrice,0.23);
echo "My age is : ".$myResult . ".<HR>" ;

echo "The VAT you need to pay is " .number_format($myVAT,2). ".<HR>";
 " on ".$myPrice;

$Street = 124;

?>