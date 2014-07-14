<?php

	include_once("Database.php");

	class Estado{

		private $id 		;
		private $nombre		;
		private $clave		;
		private $abreviatura ;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "estados" ;
		}

		function insert($estado){
			
		}

		function update(){

		}

		function loadAll(){
			$estados = array();
			$sql = "select * from $this->tabla";
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)>0){
				while ($estado=mysql_fetch_assoc($resultado)) {
					$estados[]=array(
									"id_estado"=>$estado['id_estado'], 
									"nombre"=>$estado['nombre'],
									"clave"=>$estado['clave'],
									"abreviatura" =>$estado['abreviatura']
									);
				}
			}
			return $estados ;
		}

		function loadById($id){
			$sql = "select * from $this->tabla where id_estado=$id";
			$resultado = mysql_query($sql, $this->conexion);
			$num_rows = mysql_num_rows($resultado) ;
			if($num_rows>0){
				$estado = mysql_fetch_assoc($resultado);
				$this->id = $estado['id_estado'];
				$this->nombre=$estado['nombre'];
			}

			return $sql ;
		}

		function getId(){
			return $this->id ;
		}

		function getNombre(){
			return $this->nombre ;
		}

		function getClave(){
			return $this->clave ;
		}

		function getAbreviatura(){
			return $this->abreviatura ;
		}

	}

?>

