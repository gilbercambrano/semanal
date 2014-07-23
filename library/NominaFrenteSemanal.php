<?php
	include_once ("Database.php");

	class NominaFrenteSemanal{

		private $id 			;
		private $monto			;
		private $observaciones	;
		private $nomina_general_semanal ;
		private $frente_trabajo	;
		private $estatus 		;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "nominas_frentes_semanales";
		}

		function insert($nomina_general_semanal, $frente_trabajo){
			$sql = "insert into $this->tabla values(
				0,
				0,
				'',
				".$nomina_general_semanal.",
				".$frente_trabajo.",
				'ACTIVO'
				)";
			return mysql_query($sql, $this->conexion);
		}

		function insertNuevo($nomina_general_semanal, $frente_trabajo){
			$sql = "insert into $this->tabla values(
				0,
				0,
				'',
				".$nomina_general_semanal.",
				".$frente_trabajo.",
				'ACTIVO'
				)";
			 mysql_query($sql, $this->conexion);
			 return mysql_insert_id();
		}

		function update($nomina_frente){
			$sql = "update $this->tabla set 
			monto=".$nomina_frente['monto'].", 
			observaciones='".$nomina_frente['observaciones']."', 
			estatus='".$nomina_frente['estatus']."'

			where id_nomina_frente_semanal=".$nomina_frente['id_nomina_frente_semanal']."
			";
			mysql_query($sql, $this->conexion);
		}


		function updateEstatus($id_nomina_frente_semanal, $estatus_){

			$sql = "update $this->tabla set 
				estatus='".$estatus_."'
				where id_nomina_frente_semanal = ".$id_nomina_frente_semanal;

				return mysql_query($sql) ;
				//return $sql ;

		}



		function updateMonto($id_nomina_frente_semanal, $monto){

			$sql = "update $this->tabla set 
				monto='".$monto."'
				where id_nomina_frente_semanal = ".$id_nomina_frente_semanal;

				return mysql_query($sql) ;
				//return $sql ;

		}

		function loadByFrente($frente){
			$sql = "select * from $this->tabla where id_frente_trabajo=$frente and estatus='ACTIVO'" ;
			$resultado = mysql_query($sql, $this->conexion);
			//$nominas = array();
			if(mysql_num_rows($resultado) > 0){
				while($row = mysql_fetch_assoc($resultado)){
					$this->id = $row['id_nomina_frente_semanal'];
					$this->monto = $row['monto'];
					$this->observaciones = $row['observaciones'];
					$this->nomina_general_semanal = $row['id_nomina_general_semanal'];
					$this->frente_trabajo = $row ['id_frente_trabajo'];
					$this->estatus = $row['estatus'];
				}
			}
			//return $nominas ;
		}

		function loadById($nomina){
			$sql = "select * from $this->tabla where id_nomina_frente_semanal=$nomina and estatus='ACTIVO'" ;
			$resultado = mysql_query($sql, $this->conexion);
			//$nominas = array();
			if(mysql_num_rows($resultado) > 0){
				while($row = mysql_fetch_assoc($resultado)){
					$this->id = $row['id_nomina_frente_semanal'];
					$this->monto = $row['monto'];
					$this->observaciones = $row['observaciones'];
					$this->nomina_general_semanal = $row['id_nomina_general_semanal'];
					$this->frente_trabajo = $row ['id_frente_trabajo'];
					$this->estatus = $row['estatus'];
				}
			}
		}

		function loadByActivo_(){
			$sql = "select * from $this->tabla where estatus='ACTIVO'" ;
			$resultado = mysql_query($sql, $this->conexion);
			$nominas = array();
			if(mysql_num_rows($resultado) > 0){
				while($row = mysql_fetch_assoc($resultado)){
					$nominas [] = $row ;
				}
			}
			return $nominas ;
		}

		function loadByActivo(){
			$sql = "select * from $this->tabla where estatus='ACTIVO'" ;
			$resultado = mysql_query($sql, $this->conexion);
			//$nominas = array();
			if(mysql_num_rows($resultado) > 0){
				while($row = mysql_fetch_assoc($resultado)){
					$this->id = $row['id_nomina_frente_semanal'];
					$this->monto = $row['monto'];
					$this->observaciones = $row['observaciones'];
					$this->nomina_general_semanal = $row['id_nomina_general_semanal'];
					$this->frente_trabajo = $row ['id_frente_trabajo'];
					$this->estatus = $row['estatus'];
				}
			}
		}

		function getTotalNominasFrentes($nomina_general){
			$sql = "select sum(monto) from $this->tabla where id_nomina_general_semanal =" . $nomina_general ;
			$resultado = mysql_query($sql, $this->conexion) ;
			if(mysql_num_rows($resultado)>0){
				$total = mysql_fetch_array($resultado);
				return $total[0];
			}
			else{
				return 0 ;
			}
		}

		function loadByNominaGeneralSemanal($nomina){
			$sql = "select * from $this->tabla where id_nomina_general_semanal = $nomina and estatus='ACTIVO'" ;
			$nominas_frentes = array();
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado) > 0){
				while($row = mysql_fetch_assoc($resultado)){
					$nominas_frentes[] = $row ;
				}
			}
			return $nominas_frentes ;
		}

		function loadAll(){

		}

		function loadByNominaGeneralSemanal2($nomina){
			$sql = "select * from $this->tabla where id_nomina_general_semanal = $nomina";
			$nominas_frentes = array();
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado) > 0){
				while($row = mysql_fetch_assoc($resultado)){
					$nominas_frentes[] = $row ;
				}
			}
			return $nominas_frentes ;
		}		

		function getId(){
			return $this->id ;
		}

		function getMonto(){
			return $this->monto ;
		}

		function getObservaciones(){
			return $this->observaciones ;
		}

		function getNominaGeneralSemanal(){
			return $this->nomina_general_semanal ;
		}

		function getFrenteTrabajo(){
			return $this->frente_trabajo ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

	}
?>