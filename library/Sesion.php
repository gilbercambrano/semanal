<?php

	include_once("Database.php") ;

	class Sesion{

		private $id 		;
		private $usuario 	;
		private $ip_acceso	;
		private $usuario_pc	;
		private $remote_host;
		private $fecha_ingreso ;
		private $fecha_salida ;
		private $estatus ;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "sesiones";
		}

		function insert( $sesion ){
			$sql = "insert into $this->tabla value(
					0,
					".$sesion['usuario'].",
					'".$sesion['ip_acceso']."',
					'".$sesion['usuario_pc']."',
					'".$sesion['remote_host']."',
					now(),
					now(),
					0
				)";
				mysql_query($sql, $this->conexion);
			return mysql_insert_id();
		}



		function updateSalida( $sesion ){
			$sql = "update $this->tabla set
					fecha_salida=now(),
					estatus = 0 
					where id_sesion = ".$sesion."
				";
				mysql_query($sql, $this->conexion);
				echo $sql;
			//return mysql_insert_id();
		}

		function loadAll(){

		}

		function getForIngreso($id_usuario){
			$sql = "select estatus from $this->tabla where usuario = $id_usuario and estatus = 1 ";

			$resultado = mysql_query($sql) ;
			if(mysql_num_rows($resultado) > 0){
				return 1 ;
			}
			else{
				return 0 ;
			}
		}

		

		function loadById($sesion){
			$sql = "select * from $this->tabla where id_sesion=$sesion";
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)>0){
				$row = mysql_fetch_assoc($resultado);
				$this->id = $row['id_sesion'];
				$this->usuario = $row['usuario'];
				$this->ip_acceso = $row['ip_acceso'] ;
				$this->usuario_pc = $row['usuario_pc'];
				$this->remote_host = $row['remote_host'];
				$this->fecha_ingreso = $row['fecha_ingreso'];
				$this->fecha_salida = $row['fecha_salida'];
				$this->estatus = $row['estatus'];
			}
		}

		function getId(){
			return $this->id ;
		}

		function getUsuario(){
			return $this->usuario ;
		}

		function getIpAcceso(){
			return $this->ip_acceso ;
		}

		function getUsuarioPc(){
			return $this->usuario_pc ;
		}

		function getRemoteHost(){
			return $this->remote_host ;
		}

		function getFechaIngreso(){
			return $this->fecha_ingreso ;
		}

		function getFechaSalida(){
			return $this->fecha_salida ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

	}

?>