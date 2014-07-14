<?php

	include_once("Database.php") ;

	class Localidad{

		private $id 		;
		private $nombre 	;
		private $municipio 	;
		private $clave 		;
		private $latitud 	;
		private $longitud	;
		private $altitud 	;
		private $m 			;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "localidades";
		}

		function insert($municipio){

		}

		function update(){

		}

		function loadAll(){
			$sql = "select * from $this->tabla " ;
			$localidades = array();
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)>0){
				while($localidad=mysql_fetch_assoc($resultado)){
					$localidades[]= array(
											"id_municipio" => $localidad['id_municipio'],
											"nombre" => $localidad['nombre'],
											"id_estado" => $localidad['id_estado']
										);
					
				}
				return $localidades ;
			}
			else{
				return null ;
			}
		}

		function getLocalidadesAutocomplete($municipio, $input){

			$sql = "select * from $this->tabla where id_municipio=$municipio and nombre like '%".$input."%' limit 10";
			$resultado = mysql_query($sql, $this->conexion);


			$localidades = array() ;
			while ($row = mysql_fetch_assoc($resultado) ) {
							$localidades[] = array(
								"id" => $row['id_localidad'],
								"value" => $row['nombre'],
								"label" => $row['nombre']
								);
						}			

			
			return json_encode($localidades, true);
		}

		function getJson(){
			return json_encode($this->loadAll(), true);
		}

		function updateMunicipio($d, $mun){
			$sql = "update $this->tabla set m=$mun where id_localidad=$d" ;
			mysql_query($sql, $this->conexion);
		}

		function loadById($localidad){
			$sql="select * from $this->tabla where id_localidad=$localidad";
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)>0){
				$row = mysql_fetch_assoc($resultado);
				$this->id = $row['id_localidad'];
				$this->nombre = $row['nombre'];
				$this->municipio = $row['id_municipio'];
				$this->clave = $row['clave'];
				$this->latitud = $row['latitud'];
				$this->longitud = $row['longitud'];
				$this->altitud = $row['altitud'];
				$this->m = $row['m'] ;
			}
			return $sql ;
		}

		function getId(){
			return $this->id ;
		}

		function getNombre(){
			return $this->nombre ;
		}

		function getMunicipio(){
			return $this->municipio ;
		}

		function getM(){
			return $this->m ;
		}

	}

?>