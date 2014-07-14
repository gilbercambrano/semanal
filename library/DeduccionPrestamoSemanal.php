<?php

	include_once("Database.php") ;

	class DeduccionPrestamoSemanal{

		private $id 			;
		private $monto 			;
		private $fecha_pago 	;
		private $estatus 		;
		private $acumulado 		;
		private $restante 		;
		private $prestamo 		;
		private $empleado_nomina_frente_semanal ;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "deducciones_prestamos_semanales";
		}

		function insert($area_departamento, $jefe){

		}

		function update(){

		}

		function loadByEmpleadoNomina($nomina){
			$sql = "select * from $this->tabla where id_empleado_nomina_frente_semanal = $nomina and estatus = 'ACTIVO'";
			$resultado = mysql_query($sql, $this->conexion) ;
			$deducciones = array();
			if(mysql_num_rows($resultado)>0){
				while($row = mysql_fetch_assoc($resultado)){
					$deducciones[] = $row ;
				}
			}
			return $deducciones ;
		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getMonto(){
			return $this->monto ;
		}

		function getFechaPago(){
			return $this->fecha_pago ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getAcumulado(){
			return $this->acumulado ;
		}

		function getRestante(){
			return $this->restante ;
		}

		function getPrestamo(){
			return $this->prestamo ;
		}

		function getEmpleadoNominaFrenteSemanal(){
			return $this->empleado_nomina_frente_semanal ;
		}

	}

?>