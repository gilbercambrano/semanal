<?php
	
	include_once("Database.php");

	class EmpleadoNominaFrenteSemanal{
	
		private $id				;
		private $estatus		;
		private $observaciones	;
		private $empleado 		;
		private $nomina_frente	;
		private $lunes			;
		private $martes			;
		private $miercoles		;
		private $jueves			;
		private $viernes		;
		private $sabado			;
		private $domingo		;
		private $monto			;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "empleados_nominas_frentes_semanal";
		}

		function insert($empleado, $nomina_frente){

		}

		function update($empleado_nomina_frente_semanal){

			$sql = "update $this->tabla set 
				estatus='".$empleado_nomina_frente_semanal['estatus']."',
				observaciones='".$empleado_nomina_frente_semanal['observaciones']."',
				lunes=".$empleado_nomina_frente_semanal['lunes'].",
				martes=".$empleado_nomina_frente_semanal['martes'].",
				miercoles=".$empleado_nomina_frente_semanal['miercoles'].",
				jueves=".$empleado_nomina_frente_semanal['jueves'].",
				viernes=".$empleado_nomina_frente_semanal['viernes'].",
				sabado=".$empleado_nomina_frente_semanal['sabado'].",
				domingo=".$empleado_nomina_frente_semanal['domingo'].",
				monto=".$empleado_nomina_frente_semanal['monto']." 
				where id_empleado_nomina_frente_semanal = ".$empleado_nomina_frente_semanal['id_empleado_nomina_frente_semanal'];

				return mysql_query($sql) ;

		}

		function updateFrente($empleado_nomina_frente_semanal, $frente){

			$sql = "update $this->tabla set 
				id_nomina_frente=".$frente." 
				where id_empleado_nomina_frente_semanal = ".$empleado_nomina_frente_semanal;

				mysql_query($sql) ;
				//return $sql ;

		}

		function updateEstatus($id_empleado_nomina_frente_semanal, $estatus_){

			$sql = "update $this->tabla set 
				estatus='".$estatus_."'
				where id_empleado_nomina_frente_semanal = ".$id_empleado_nomina_frente_semanal;

				return mysql_query($sql) ;
				//return $sql ;

		}

		function updateMonto($id_empleado_nomina_frente_semanal, $monto_){

			$sql = "update $this->tabla set 
				monto=".$monto_."
				where id_empleado_nomina_frente_semanal = ".$id_empleado_nomina_frente_semanal;

				return mysql_query($sql) ;
				//return $sql ;

		}

		function loadById($id){
			$sql = "select * from $this->tabla where id_empleado_nomina_frente_semanal=$id and estatus='REVISADA'";
			$resultado = mysql_query($sql, $this->conexion) ;
			if(mysql_num_rows($resultado)>0){
				$row = mysql_fetch_assoc($resultado);
				$this->id=$row['id_empleado_nomina_frente_semanal'];
				$this->estatus= $row['estatus'];
				$this->observaciones=$row['estatus'];
				$this->empleado=$row['id_empleado'];
				$this->nomina_frente=$row['id_nomina_frente'];
				$this->lunes=$row['lunes'];
				$this->martes=$row['martes'];
				$this->miercoles=$row['miercoles'];
				$this->jueves=$row['jueves'];
				$this->viernes=$row['viernes'];
				$this->sabado=$row['sabado'];
				$this->domingo=$row['domingo'];
				$this->monto=$row['monto'];
			}
			return mysql_error();
		}

		function loadByEmpleado($empleado){
			$sql = "select * from $this->tabla where id_empleado=$empleado and estatus='REVISADA'";
			$resultado = mysql_query($sql, $this->conexion) ;
			if(mysql_num_rows($resultado)>0){
				$row = mysql_fetch_assoc($resultado);
				$this->id=$row['id_empleado_nomina_frente_semanal'];
				$this->estatus= $row['estatus'];
				$this->observaciones=$row['estatus'];
				$this->empleado=$row['id_empleado'];
				$this->nomina_frente=$row['id_nomina_frente'];
				$this->lunes=$row['lunes'];
				$this->martes=$row['martes'];
				$this->miercoles=$row['miercoles'];
				$this->jueves=$row['jueves'];
				$this->viernes=$row['viernes'];
				$this->sabado=$row['sabado'];
				$this->domingo=$row['domingo'];
				$this->monto=$row['monto'];
			}
			return mysql_num_rows($resultado);
		}

		function loadAll(){

		}

		function delete($nomina){
			$sql = "delete from $this->tabla where id_empleado_nomina_frente_semanal = $nomina";
			mysql_query($sql, $this->conexion);
		}


			function generaNominaEmpleadoTemp($empleado){
					$insert = "insert into empleados_nominas_frentes_semanal values(
						0, 
						'REVISADA',
						'',
						".$empleado['id_empleado'].",
						".$empleado['id_nomina_frente_semanal'].",
						0,
						0,
						0,
						0,
						0,
						0,
						0,
						0
						)";

					mysql_query($insert, $this->conexion);

			return mysql_insert_id();
		}

		function loadByNominaFrenteSemanal($nomina){
			$sql2 = "select * from $this->tabla where id_nomina_frente=$nomina and (estatus='ACTIVO' or estatus='REVISADA' )";
			$resultado = mysql_query($sql2, $this->conexion);
			$nominas_empleados = array();
			if(mysql_num_rows($resultado)>0){
				while($row=mysql_fetch_assoc($resultado)){
					$nominas_empleados[]=$row ;
				}
			}
			return $nominas_empleados ;
			//return $sql2;
		}

		function getId(){
			return $this->id ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getObservaciones(){
			return $this->observaciones ;
		}

		function getEmpleado(){
			return $this->empleado ;
		}

		function getNominaFrente(){
			return $this->nomina_frente ;
		}

		function getLunes(){
			return $this->lunes ;
		}

		function getMartes(){
			return $this->martes ;
		}

		function getMiercoles(){
			return $this->miercoles ;
		}

		function getJueves(){
			return $this->jueves ;
		}

		function getViernes(){
			return $this->viernes ;
		}

		function getSabado(){
			return $this->sabado ;
		}

		function getDomingo(){
			return $this->domingo ;
		}

		function getMonto(){
			return $this->monto ;
		}

	}
?>