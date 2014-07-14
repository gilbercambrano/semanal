<?php

	include_once("Database.php") ;

	class CompaniaEmpleado{

		private $id 		;
		private $compania 	;
		private $empleado 	;
		private $estatus 	;
		private $fecha_inicio ;
		private $fecha_fin 	;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "companias_empleados";
		}

		function insert($compania_empleado){

			$sql = "insert into $this->tabla values(
				0, 
				".$compania_empleado['id_compania'].",
				".$compania_empleado['id_empleado'].",
				'".$compania_empleado['estatus']."',
				'".$compania_empleado['fecha_inicio']."',
				'".$compania_empleado['fecha_fin']."'
				)";

				mysql_query($sql, $this->conexion);

				return mysql_insert_id();

		}

		function loadByEmpleado($empleado){
			$sql = "select * from $this->tabla where estatus='ACTIVO' and id_empleado=$empleado";
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)){
				$row=mysql_fetch_assoc($resultado);
				$this->id = $row['id_compania_empleado'];
				$this->compania = $row['id_compania'];
				$this->empleado = $row['id_empleado'];
				$this->estatus = $row['estatus'];
				$this->fecha_inicio = $row ['fecha_inicio'];
				$this->fecha_fin = $row['fecha_fin'];
			}
			return $sql ;
		}

		function deleteForEmpleadoEstatus($empleado, $estatus){
			$sql = "update $this->tabla
				set estatus = 'CANCELADO',
					fecha_fin = '".date("Y-m-d")."'
			 	where id_empleado = $empleado and estatus ='" .$estatus."'";
			mysql_query($sql, $this->conexion);
			return $sql ;
		}

		function update($ce){
			$sql = "update $this->tabla set 
			id_compania=".$ce['id_compania'].",
			id_empleado=".$ce['id_empleado'].",
			estatus='".$ce['estatus']."',
			fecha_inicio='".$ce['fecha_inicio']."',
			fecha_fin='".$ce['fecha_fin']."'
			where id_compania_empleado = ".$ce['id_compania_empleado'];

			mysql_query($sql, $this->conexion) ;
		//	return $sql ;
		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getCompania(){
			return $this->compania ;
		}

		function getEmpleado(){
			return $this->empleado ;
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

	}

?>