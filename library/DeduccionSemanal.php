<?php

	include_once("Database.php");

	class DeduccionSemanal{

		private $id 			;
		private $fecha			;
		private $estatus		;
		private $descripcion	;
		private $monto 			;
		private $nomina_semanal_empleado ;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "deducciones_semanales";
		}

		function insert($deduccion){
			$sql = "insert into $this->tabla values(
				0,
				'".date('Y-m-d')."',
				'PENDIENTE',
				'".$deduccion['descripcion']."',
				".$deduccion['monto'].",
				".$deduccion['id_empleado_nomina_frente_semanal']."
				)";

				return mysql_query($sql, $this->conexion);
		}

		function update($deduccion){
			$sql = "update $this->tabla set
				estatus='".$deduccion['estatus']."',
				descripcion='".$deduccion['descripcion']."',
				monto=".$deduccion['monto']."
				where id_empleado_nomina_frente_semanal =".$deduccion['id_empleado_nomina_frente_semanal'];
			mysql_query($sql, $this->conexion);
			return $sql ;

		}

		function loadById($deduccion){
			$sql = "select * from $this->tabla where id_deduccion_semanal=$deduccion";
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)>0){
				$row = mysql_fetch_assoc($resultado);
				$this->id = $row['id_deduccion_semanal'];
				$this->monto = $row['monto'];
				$this->fecha = $row['fecha'] ;
				$this->estatus = $row['estatus'];
				$this->descripcion = $row['descripcion'];
				$this->nomina_semanal_empleado = $row['nomina_semanal_empleado'];
			}
		}

		function loadByEmpleadoNomina($empleado_nomina){
			$indicador = 0 ;
			$sql = "select * from $this->tabla where id_empleado_nomina_frente_semanal=$empleado_nomina and estatus='PENDIENTE' ";
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)>0){
				$indicador = 1 ;
				$row = mysql_fetch_assoc($resultado);
				$this->id = $row['id_deduccion_semanal'];
				$this->monto = $row['monto'];
				$this->fecha = $row['fecha'] ;
				$this->estatus = $row['estatus'];
				$this->descripcion = $row['descripcion'];
				$this->nomina_semanal_empleado = $row['id_empleado_nomina_frente_semanal'];
			}
			//echo $sql ;
			return $indicador ;
		}


		function updateEstatus($deduccion, $estatus){
			$sql = "update $this->tabla set
				estatus='".$estatus."'
				where id_deduccion_semanal =".$deduccion."
				";
			return mysql_query($sql, $this->conexion);
			//return $sql ;

		}

		function loadAll(){
			$sql = "select * from $this->tabla";
			$resultado = mysql_query($sql, $this->conexion);
			$deducciones = array();
			if(mysql_num_rows($resultado) > 0){
				while($row = mysql_fetch_assoc($resultado)){
					$deducciones[]=$row;
				}
			}
			return $deducciones ;
		}

		function getId(){
			return $this->id ;
		}

		function getMonto(){
			return $this->monto ;
		}

		function getFecha(){
			return $this->fecha ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getDescripcion(){
			return $this->descripcion ;
		}

		function getNominaSemanalEmpleado(){
			return $this->nomina_semanal_empleado ;
		}
	}

?>