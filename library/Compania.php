<?php

	include_once("Database.php") ;

	class Compania{

		private $id 			;
		private $compania 		;
		private $abreviatura 	;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "companias";
		}

		function insert(){

		}

		function update(){

		}

		function loadById($compania){
			$sql = "select * from $this->tabla where id_compania = $compania";
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)){
				$row=mysql_fetch_assoc($resultado);
				$this->id=$row['id_compania'];
				$this->compania = $row['compania'];
				$this->abreviatura = $row['abreviatura'];
			}
		
		}

		function loadAll(){
			$sql = "select * from  $this->tabla";
			$resultado = mysql_query($sql, $this->conexion);
			$companias = array();
			if(mysql_num_rows($resultado)>0){
				while($row = mysql_fetch_assoc($resultado)){
					$companias[]=array(
							'id_compania'=>$row['id_compania'],
							'compania'=>$row['compania'],
							'abreviatura' => $row['abreviatura']
						);
				}
				return $companias ;
			}
			else{
				return null ;
			}
		}

		function getId(){
			return $this->id ;
		}

		function getCompania(){
			return $this->compania ;
		}

		function getAbreviatura(){
			return $this->abreviatura ;
		}


	}

?>