<?php

	include_once("Database.php") ;

	class NominaGeneralSemanal{

		private $id 			;
		private $fecha_pago		;
		private $monto 			;
		private $estatus 		;
		private $fecha_inicio_periodo ;
		private $fecha_fin_periodo ;
		private $fecha_generacion ;
		private $usuario		;
		private $comentario 	;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "nominas_generales_semanales";
		}

		function loadByActivo(){
			$sql = "select * from $this->tabla where estatus='ACTIVO'";
			$resultado = mysql_query($sql, $this->conexion) ;
			if(mysql_num_rows($resultado)>0){
				$row = mysql_fetch_assoc($resultado);
				$this->id=$row['id_nomina_general_semanal'];
				$this->fecha_pago = $row['fecha_pago'];
				$this->monto=$row['monto'];
				$this->estatus = $row['estatus'] ;
				$this->fecha_inicio_periodo = $row['fecha_inicio_periodo'];
				$this->fecha_fin_periodo = $row['fecha_fin_periodo'];
				$this->fecha_generacion = $row['fecha_generacion'];
				$this->usuario=$row['id_usuario'];
				$this->comentario = $row['comentarios'];
			}
		}

		function updateMonto($nomina, $monto){
			$sql = "update $this->tabla set monto = $monto where id_nomina_general_semanal = $nomina" ;
			return mysql_query($sql, $this->conexion) ;
		}

		function insert(/*$usuario*/){
			$this->loadByActivo();
			$this->saldarNomina($this->id);
			$usuario = 1 ;
			$sql = "insert into nominas_generales_semanales values( 0, now(), 0, 'ACTIVO', now(), now(), now(), $usuario, '' )" ;
			mysql_query($sql, $this->conexion );
			return mysql_insert_id();
		}

		function insertNuevo(/*$usuario*/){
			/*$this->loadByActivo();
			$this->saldarNomina($this->id); */
			$usuario = 1 ;
			$sql = "insert into nominas_generales_semanales values( 0, now(), 0, 'ACTIVO', now(), now(), now(), $usuario, '' )" ;
			mysql_query($sql, $this->conexion );
			return mysql_insert_id();
		}

		function saldarNomina( $nomina ){
			$sql = "update $this->tabla set estatus='PAGADA' where id_nomina_general_semanal = $nomina ";
			mysql_query($sql, $this->conexion);
		}

		function update(){

		}

		function loadById($id){
			$sql = "select * from $this->tabla where id_nomina_general_semanal = $id";
			$resultado = mysql_query($sql, $this->conexion) ;
			if(mysql_num_rows($resultado)>0){
				$row = mysql_fetch_assoc($resultado);
				$this->id=$row['id_nomina_general_semanal'];
				$this->fecha_pago = $row['fecha_pago'];
				$this->monto=$row['monto'];
				$this->estatus = $row['estatus'] ;
				$this->fecha_inicio_periodo = $row['fecha_inicio_periodo'];
				$this->fecha_fin_periodo = $row['fecha_fin_periodo'];
				$this->fecha_generacion = $row['fecha_generacion'];
				$this->usuario=$row['id_usuario'];
				$this->comentario = $row['comentarios'];
			}
		}

		function loadByEstatus($estatus){

			$sql = "select * from $this->tabla where estatus='".$estatus."'" ;
			$resultado = mysql_query($sql, $this->conexion);
			$nominas = array();
			if(mysql_num_rows($resultado) > 0){
				while($row = mysql_fetch_assoc($resultado)){
					$nominas [] = $row ;
				}
			}
			return $nominas ;
		}		

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getFechaPago(){
			return $this->fecha_pago ;
		}

		function getMonto(){
			return $this->monto ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getFechaInicioPeriodo(){
			return $this->fecha_inicio_periodo ;
		}

		function getFechaFinPeriodo(){
			return $this->fecha_fin_periodo ;
		}

		function getFechaGeneracion(){
			return $this->fecha_generacion ;
		}

		function getUsuario(){
			return $this->usuario ;
		}

		function getComentario(){
			return $this->comentario ;
		}

	}

?>