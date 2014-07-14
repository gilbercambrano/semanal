<?php
include_once("../library/Clinica.php");
$clinica = new Clinica();
echo $clinica->getJson();
?>