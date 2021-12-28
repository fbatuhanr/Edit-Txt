<?php 
/* 
* BATUHAN OZTURK 2020 | All rights reserved.
*/
  
// get websites main url
$mainUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

// turkish char converter -fixer
function TurkishCharConverter($thisWord){
   $findingChar = array("ç","Ç","ğ","Ğ","ı","İ","ö","Ö","ş","Ş","ü","Ü"," ");
   $replaceWith = array("c","c","g","g","i","i","o","o","s","s","u","u","_");
   return str_replace($findingChar, $replaceWith, $thisWord);
}

?>