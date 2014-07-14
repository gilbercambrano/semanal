<?php
	include_once("Database.php");

	class FrenteTrabajo{

		private $id 		;
		private $nombre		;
		private $estatus	;
		private $activo_sector ;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "frentes_trabajo" ;
		}

		function loadById($id) {
			$sql = "select * from $this->tabla where id_frente_trabajo = $id" ;
			$resultado =mysql_query($sql, $this->conexion) ;
			if(mysql_num_rows($resultado)>0){
				$row = mysql_fetch_assoc($resultado) ;
				$this ->id = $row['id_frente_trabajo'];
				$this->nombre = $row['nombre'];
				$this->estatus=$row['estatus'];
				$this->activo_sector = $row['id_activo_sector'];
			}
		}

		function insert($activo_sector){
			$sql = "insert into $this->tabla values(
				0, 

				'".$activo_sector['nombre']."',
				'ACTIVO',
				".$activo_sector['id_activo_sector']."
				)";
			 mysql_query($sql, $this->conexion);
			 return mysql_insert_id();
		}

		function update(){

		}

		function loadAll(){
			$sql = "select * from $this->tabla order by nombre";
			$resultado = mysql_query($sql, $this->conexion);
			$frentes = array();
			if(mysql_num_rows($resultado) > 0){
				while($row = mysql_fetch_assoc($resultado)){
					$frentes[]=$row;
				}
			}
			return $frentes ;
		}

		function getId(){
			return $this->id ;
		}

		function getNombre(){
			return $this->nombre ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getActivoSector(){
			return $this->activo_sector ;
		}

	}

?>