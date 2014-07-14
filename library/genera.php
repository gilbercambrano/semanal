<?php

	include_once("GeneraNominaSemanal.php");

	$genera_nomina = new GeneraNominaSemanal();

	///echo $genera_nomina -> generaNominaFrentes();

	//echo $genera_nomina->generaNominaEmpleado();
	set_time_limit(0);
	$genera_nomina->generaByNominaOld();

?>