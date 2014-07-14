<?php

	include_once("Database.php");

	class Municipio{

		private $id 		;
		private $nombre		;
		private $estado		;
		private $clave 		;
		private $sigla 		;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "municipios";
		}

		function insert($estado){

		}

		function update(){

		}

		function loadById($municipio){
			$sql = "select * from municipios where id_municipio=".$municipio ;
			$municipios = array();
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)>0){
				while($row=mysql_fetch_assoc($resultado)){
					$this->id = $row['id_municipio'];
					$this->nombre = $row['nombre'];
					$this->estado = $row['id_estado'] ;
					
				}
			}
			return $sql ;
		}

		function loadAll(){
			$sql = "select * from municipios " ;
			$municipios = array();
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)>0){
				while($municipio=mysql_fetch_assoc($resultado)){
					$municipios[]= array(
											"id_municipio" => $municipio['id_municipio'],
											"nombre" => $municipio['nombre'],
											"id_estado" => $municipio['id_estado']
										);
					
				}
				return $municipios ;
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

		function getNombre(){
			return $this->nombre ;
		}

		function getEstado(){
			return $this->estado;
		}

	}

?>