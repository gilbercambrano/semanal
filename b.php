<?php
	$conexion = mysql_connect('localhost', 'root', 'gilcamlop') ;
	mysql_select_db("smt_database") ;
	$sql = "select * from empleados where estatus!='LABORANDO'" ;
	$res = mysql_query($sql, $conexion);
	$contador = 0;
	while ($row = mysql_fetch_array($res)) {
		echo ++$contador . "------" .$row[0] . " " .$row[1] . " " .$row[2] . " " .$row[3] . " <br><br>"  ;
		mysql_query(
			"update empleados_puestos set estatus = 'CANCELADO', fecha_fin = '2013-03-21' where id_empleado = ".$row[0]." and estatus ='ACTIVO'",
			$conexion
			);
		mysql_query(
			"update companias_empleados set estatus = 'CANCELADO', fecha_fin = '2013-03-21' where id_empleado = ".$row[0]." and estatus ='ACTIVO'",
			$conexion
			);
	}
?>