<?php

	include_once("Database.php");
	include_once("NominaGeneralSemanal.php");
	include_once("EmpleadoNominaFrenteSemanal.php");
	include_once("NominaFrenteSemanal.php");

	

	class GeneraNominaSemanal{

		private $conexion ;


		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			
		}

		function generaNominaFrentes(){
			$sql_frentes_trabajo = "select * from frentes_trabajo where estatus ='ACTIVO'";
			$frentes_trabajo = mysql_query($sql_frentes_trabajo, $this->conexion );

			$sql_nomina_general = "select * from nominas_generales_semanales where estatus='ACTIVO'" ;
			$nomina_general_semanal = mysql_query($sql_nomina_general, $this->conexion);

			if(mysql_num_rows($nomina_general_semanal)>0){
				$row = mysql_fetch_assoc($nomina_general_semanal) ;
				$id_nomina_general_semanal = $row['id_nomina_general_semanal'] ;
			}
			$r = 0;
			if(mysql_num_rows($frentes_trabajo)>0){
				while($frente_trabajo = mysql_fetch_assoc($frentes_trabajo)){
					$insert = "insert into nominas_frentes_semanales values(
						0, 
						0,
						'',
						$id_nomina_general_semanal,
						".$frente_trabajo['id_frente_trabajo'].",
						'ACTIVO'
						)";

					$r +=mysql_query($insert, $this->conexion);

				}
			}
			return $r;
		}

		function generaByNominaOld(){
			
			$nomina_general_semanal_object = new NominaGeneralSemanal();

			$nomina_frente_semanal = new NominaFrenteSemanal();

			$empleado_nomina_frente_semanal = new EmpleadoNominaFrenteSemanal();

			$id_nomina_gral = $nomina_general_semanal_object->insert(/* $usuario */);

			$sql = "select * from nominas_frentes_semanales where estatus='ACTIVO'";

			$resultado = mysql_query($sql, $this->conexion);

			while($row=mysql_fetch_assoc($resultado)){
				$insert = "insert into nominas_frentes_semanales values(
					0, 
					0,
					'',
					".$id_nomina_gral.",
					".$row['id_frente_trabajo'].",
					'ACTIVO'
					)";
				
				$nomina_frente_semanal->loadById($row['id_nomina_frente_semanal']);

				$nomina_frente_semanal->update( array(
													'id_nomina_frente_semanal' => $nomina_frente_semanal->getId() ,
													'monto' => $nomina_frente_semanal->getMonto(),
													'observaciones'=>$nomina_frente_semanal->getObservaciones(),
													'estatus'=>'PAGADA'
													) );

				mysql_query($insert);
				$id_nomina=mysql_insert_id();
				
				$empleados_nominas = "select * from empleados_nominas_frentes_semanal where id_nomina_frente=" .$row['id_nomina_frente_semanal'];

				$res_empleados = mysql_query($empleados_nominas, $this->conexion);
				while ($fila = mysql_fetch_assoc($res_empleados)) {
				$empleado_nomina_frente_semanal->loadById($fila['id_empleado_nomina_frente_semanal']);

				$insert_nomina = "insert into empleados_nominas_frentes_semanal values(
						0, 
						'REVISADA',
						'',
						".$fila['id_empleado'].",
						".$id_nomina.",
						0,
						0,
						0,
						0,
						0,
						0,
						0,
						0
						)"; 
				
				$empleado_nomina_frente_semanal->updateEstatus($fila['id_empleado_nomina_frente_semanal'], 'PAGADA');

					mysql_query($insert_nomina);

				}

			}

		}



		function generaNominaEmpleado(){
			$sql_empleados = "select * from empleados where estatus ='LABORANDO'";
			$empleados = mysql_query($sql_empleados, $this->conexion );

			$sql_nomina_frente = "select * from nominas_frentes_semanales where estatus='ACTIVO'" ;
			$nomina_frente_semanal = mysql_query($sql_nomina_frente, $this->conexion);

			if(mysql_num_rows($nomina_frente_semanal)>0){
				$row = mysql_fetch_assoc($nomina_frente_semanal) ;
				$id_nomina_frente_semanal = $row['id_nomina_frente_semanal'] ;
			}
			$r = 0;
			if(mysql_num_rows($empleados)>0){
				while($empleado = mysql_fetch_assoc($empleados)){
					
					$insert = "insert into empleados_nominas_frentes_semanal values(
						0, 
						'ACTIVO',
						'',
						".$empleado['id_empleado'].",
						".$id_nomina_frente_semanal.",
						0,
						0,
						0,
						0,
						0,
						0,
						0,
						0
						)";

					$r +=mysql_query($insert, $this->conexion);

				}
			}
			return $r;
		}



	}

?>