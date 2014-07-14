<?php

	include_once("Database.php") ;

	class CuentaBancaria{

		private $id 			;
		private $banco 			;
		private $numero_cuenta	;
		private $clabe 			;
		private $tipo_cuenta	;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "cuentas_bancarias";
		}

		function insert( $cuenta_bancaria ){
			$sql = "insert into $this->tabla value(
					0,
					'".$cuenta_bancaria['banco']."',
					'".$cuenta_bancaria['numero_cuenta']."',
					'".$cuenta_bancaria['clabe']."',
					'".$cuenta_bancaria['tipo_cuenta']."'
				)";
				mysql_query($sql, $this->conexion);
			return mysql_insert_id();
		}

		function update( $cuenta_bancaria ){
			$sql = "update $this->tabla set
					
					banco='".$cuenta_bancaria['banco']."',
					numero_cuenta='".$cuenta_bancaria['numero_cuenta']."',
					clabe='".$cuenta_bancaria['clabe']."',
					tipo_cuenta ='".$cuenta_bancaria['tipo_cuenta']."'
					where id_cuenta_bancaria = ".$cuenta_bancaria['id_cuenta_bancaria']."
				";
				mysql_query($sql, $this->conexion);
			//return mysql_insert_id();
		}

		function loadAll(){

		}

		

		function loadById($cuenta_bancaria){
			$sql = "select * from $this->tabla where id_cuenta_bancaria=$cuenta_bancaria";
			$resultado = mysql_query($sql, $this->conexion);
			if(mysql_num_rows($resultado)>0){
				$row = mysql_fetch_assoc($resultado);
				$this->id = $row['id_cuenta_bancaria'];
				$this->banco = $row['banco'];
				$this->numero_cuenta = $row['numero_cuenta'] ;
				$this->clabe = $row['clabe'];
				$this->tipo_cuenta = $row['tipo_cuenta'];
			}
		}

		function getId(){
			return $this->id ;
		}

		function getBanco(){
			return $this->banco ;
		}

		function getNumeroCuenta(){
			return $this->numero_cuenta ;
		}

		function getClabe(){
			return $this->clabe ;
		}

		function getTipoCuenta(){
			return $this->tipo_cuenta ;
		}

	}

?>