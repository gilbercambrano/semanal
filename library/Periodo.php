<?php

	include_once("Database.php");

	class Periodo{

		private $id 		;
		private $nombre 	;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "periodos";
		}

		function insert(){
			
		}

		function update(){

		}

		function loadAll(){
			$sql = "select * from $this->tabla ";
			$resultado = mysql_query($sql, $this->conexion);
			$periodos = array ();
			if(mysql_num_rows($resultado) > 0){
				while($row = mysql_fetch_assoc($resultado)){
					$periodos[] = $row ;
				}
			}
			return $periodos ;
		}

		function loadById($id){
			$sql = "select * from $this->tabla" ;

			$resultado = mysql_query($sql, $this->conexion) ;
			$row = mysql_fetch_assoc($resultado) ;
			$this->id=$row['id_periodo'] ;
			$this->nombre = $row['nombre'] ;
		}

		function getId(){
			return $this->id ;
		}

		function getNombre(){
			return $this->nombre ;
		}

	}

?>