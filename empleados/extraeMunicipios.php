<?php
include_once("../library/Municipio.php");
$municipio = new Municipio();
echo $municipio->getJson();
?>