<?php
$active=2;
include_once("header.php");
?>
<style>
body {
    margin: 0;
}
</style>
<?php

foreach($tables as $n => $t){
echo "<div class='tabla'>";
echo "<h2>".$n."</h2>";
foreach($t as $f){
echo "<div class='field'>";
print_r($f);
echo "</div>";
}
echo "</div>";
}

?>
