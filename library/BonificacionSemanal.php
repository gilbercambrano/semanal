<?php
	include_once("Database.php");

	class BonificacionSemanal {

		private $id 		;
		private $fecha		;
		private $estatus	;
		private $descripcion;
		private $monto		;
		private $empleado	;
		private $nomina_frente_semanal ;
		private $numero_dias ;


		private $tabla ;
		private $conexion ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "bonificaciones_semanales";
		}

		function insert($bonificacion){
			$sql = "insert into $this->tabla values(
				0,
				now(),
				'".$bonificacion['estatus']."',
				'".$bonificacion['descripcion']."',
				".$bonificacion['monto'].",
				".$bonificacion['dias'].",
				".$bonificacion['id_empleado_nomina_frente_semanal']."
				)";
			return mysql_query($sql, $this->conexion);
		}

		function loadByEmpleadoNominaFrente( $empleado_nomina_frente ){
			$sql = "select * from $this->tabla where id_empleado_nomina_frente_semanal = $empleado_nomina_frente and estatus = 'ACTIVO'" ;
			$resultado = mysql_query($sql, $this->conexion) ;
			$bonificacion = array();
			if(mysql_num_rows($resultado)>0){
				$bonificacion=mysql_fetch_assoc($resultado) ;
			}
			return $bonificacion ;
		}	

		function update($bonificacion){
			$sql = "update $this->tabla set
				estatus='".$bonificacion['estatus']."',
				descripcion='".$bonificacion['descripcion']."',
				monto=".$bonificacion['monto'].",
				numero_dias=".$bonificacion['dias']."
				where id_bonificacion_semanal =".$bonificacion['id_bonificacion_semanal']."
				";
			mysql_query($sql, $this->conexion);
			//return $sql ;

		}


		function loadByEmpleadoNomina($empleado_nomina){
			$indicador = 0 ;
			$sql = "select * from $this->tabla where id_empleado_nomina_frente_semanal=$empleado_nomina and estatus='ACTIVO' ";
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)>0){
				$indicador = 1 ;
				$row = mysql_fetch_assoc($resultado);
				$this->id = $row['id_bonificacion_semanal'];
				$this->monto = $row['monto'];
				$this->fecha = $row['fecha'] ;
				$this->estatus = $row['estatus'];
				$this->descripcion = $row['descripcion'];
				$this->numero_dias = $row['numero_dias'] ;
				$this->nomina_semanal_empleado = $row['id_empleado_nomina_frente_semanal'];
			}
			//echo $sql ;
			return $indicador ;
		}

		function updateEstatus($bonificacion, $estatus){
			$sql = "update $this->tabla set
				estatus='".$estatus."'
				where id_bonificacion_semanal =".$bonificacion."
				";
			return mysql_query($sql, $this->conexion);
			//return $sql ;

		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
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

		function getMonto(){
			return $this->monto ;
		}

		function getEmpleado(){
			return $this->empleado ;
		}

		function getNominaFrenteSemanal(){
			return $this->nomina_frente_semanal ;
		}

	}
	
?>