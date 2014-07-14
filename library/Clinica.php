<?php

	include_once("Database.php");

	class Clinica{

		private $id 	;
		private $numero	;
		private $nombre ;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "clinicas";
		}

		function insert(){

		}

		function update(){

		}

		function loadAll(){
			$sql = "select * from $this->tabla " ;
			$clinicas = array();
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)>0){
				while($clinica=mysql_fetch_assoc($resultado)){
					$clinicas[]= array(
											"id_clinica" => $clinica['id_clinica'],
											"numero"=>$clinica['numero'],
											"nombre" => $clinica['nombre'],
											"id_estado" => $clinica['id_estado']
										);
					
				}
				return $clinicas ;
			}
			else{
				return null ;
			}
		}

		function getJson(){
			return json_encode($this->loadAll(), true);
		}

		function getId(){
			return $this->id ;
		}

		function getNumero(){
			return $this->numero ;
		}

		function getNombre(){
			return $this->nombre ;
		}

	}

?>