<?php
include_once("../library/Localidad.php");
$localidad = new Localidad();
echo $localidad->getLocalidadesAutocomplete($_GET['id_municipio'], $_GET['term']);
?>