<?php
	include_once("Database.php") ;

	class ActivoSector{

		private $id 		;
		private $nombre 	;

		private $tabla 		;

		private $conexion ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "activos_sectores" ;
		}

		function insert( $activo_sector ){
			$sql = "insert into $this->tabla values(
					0,
					'".$activo_sector['nombre']."'
				)";
			return mysql_query($sql, $this->conexion);
		}

		function update(){

		}

		function loadAll(){
			$sql="select * from $this->tabla";
			$resultado = mysql_query($sql, $this->conexion);
			$activos_sectores = array();
			if(mysql_num_rows($resultado) > 0){
				while( $activo_sector=mysql_fetch_assoc($resultado) ){
					$activos_sectores [] = $activo_sector ;
				}
			}
			return $activos_sectores ;
		}

		function loadById( $activo_sector ){
			$sql = "select * from $this->tabla where id_activo_sector = $activo_sector" ;

			$resultado = mysql_query($sql, $this->conexion) ;
			if($resultado>0){
				while ($row = mysql_fetch_assoc($resultado)) {
					$this->id = $row['id_activo_sector'] ;
					$this->nombre = $row['nombre'] ;
				}
			}
		}

		function getId(){
			return $this->id ;
		}

		function getNombre(){
			return $this->nombre;
		}

	}


?>