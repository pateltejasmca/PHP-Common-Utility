<?php
echo $string = "DEMO - 40 FT EUROPE DAP Hjørring COPENHEGAN";
echo "<br>";
$string = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $string);
echo $string;
?>
