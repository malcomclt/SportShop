<?php
function getBD(){
$bdd = new PDO('mysql:host=localhost;dbname=sportshop;charset=utf8',
'root', '');
return $bdd;
}
?>