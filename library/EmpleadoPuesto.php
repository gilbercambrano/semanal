<?php

	include_once("Database.php") ;
	include_once("EmpleadoNominaFrenteSemanal.php");

	class EmpleadoPuesto{

		private $id 		;
		private $empleado 	;
		private $puesto 	;
		private $estatus 	;
		private $fecha_inicio ;
		private $fecha_fin 	;
		private $salario 	;
		private $periodo 	;
		private $area_departamento ;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "empleados_puestos";
		}

		function insert($empleado){
			$sql = "insert into $this->tabla values(
				0, 
				".$empleado['id_empleado'].",
				".$empleado['id_puesto'].",
				'".$empleado['estatus']."',
				'".$empleado['fecha_inicio']."', 
				'".$empleado['fecha_fin']."',
				".$empleado['salario'].",
				".$empleado['id_periodo'].",
				".$empleado['id_area_departamento']."
				)";
			mysql_query($sql, $this->conexion);

			return mysql_insert_id();
		//	return $sql ;
		}

		function update($empleado){
			$sql = "update $this->tabla set
				
				id_puesto = ".$empleado['id_puesto'].",
				estatus = '".$empleado['estatus']."',
				fecha_inicio = '".$empleado['fecha_inicio']."',
				fecha_fin = '".$empleado['fecha_fin']."',
				salario = ".$empleado['salario'].",
				id_periodo = ".$empleado['id_periodo'].",
				id_area_departamento = ".$empleado['id_area_departamento']."
				where id_empleado = ". $empleado['id_empleado'] ."
				";
			mysql_query($sql, $this->conexion);
		}

		function loadByEmpleado($empleado){
			$sql = "select * from $this->tabla where estatus='ACTIVO' and id_empleado=$empleado";
			$resultado=mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)>0){
				$row = mysql_fetch_assoc($resultado);
				$this->id = $row['id_empleado_puesto'];
				$this->empleado= $row['id_empleado'];
				$this->puesto= $row['id_puesto'];
				$this->estatus=$row['estatus'];
				$this->fecha_inicio=$row['fecha_inicio'];
				$this->fecha_fin=$row['fecha_fin'];
				$this->salario = $row['salario'];
				$this->periodo = $row['id_periodo'];
				$this->area_departamento=$row['id_area_departamento'];
			}
		}

		

		function deleteForEmpleadoEstatus($empleado, $estatus){
			$sql = "update $this->tabla
				set estatus = 'CANCELADO',
					fecha_fin = '".date("Y-m-d")."'
			 	where id_empleado = $empleado and estatus ='" .$estatus."'";
			mysql_query($sql, $this->conexion);
			return $sql ;
		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getEmpleado(){
			return $this->empleado ;
		}

		function getPuesto(){
			return $this->puesto ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getFechaInicio(){
			return $this->fecha_inicio ;
		}

		function getFechaFin(){
			return $this->fecha_fin ;
		}

		function getSalario(){
			return $this->salario ;
		}

		function getPeriodo(){
			return $this->periodo ;
		}

		function getAreaDepartamento() {
			return $this->area_departamento ;
		}

		

	}

?>