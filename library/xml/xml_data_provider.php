<?php

	include ("../Municipio.php");
	header("Content-type: text/xml");
	$municipio = new Municipio();

	$all = $municipio->loadAll();

	$salida_xml = "<?xml version=\"1.0\"?>\n"; 
	$salida_xml .= "<informacion>\n";

	foreach ($all as $value) {
		$salida_xml .= "\t<municipio>\n";
		$salida_xml .= "\t\t<id_municipio>" . $value['id_municipio'] . "</id_municipio>\n";
		$salida_xml .= "\t\t<nombre>" . $value['nombre'] . "</nombre>\n";
		$salida_xml .= "\t\t<id_estado>" . $value['id_estado'] . "</id_estado>\n";
		$salida_xml .= "\t</municipio>\n";
		
	}
	$salida_xml .= "</informacion>";

	echo $salida_xml ;
?>