<?php
// VERIFICA SE EXISTEM ERROS DE EXECUÇÃO NO CÓDIGO
ini_set('display_errors',1); 

// CRIAÇÃO DA CLASSE QUE DÁ ACESSO AO BANCO
class Sql extends PDO {

	private $conn;

	
	// CRIA A CONEXÃO NO BANCO AUTOMATICAMENTE, ASSIM QUE CRIAR UM OBJETO SQL
	public function __construct(){

		/* MÉTODO COM REQUIRE */
		include("../../include_comex/comex/sqlsrv.php");

		$this->conn = new PDO("sqlsrv:Database=$db_name;server=$db_host",$db_user,$db_pass);
		
	}

	// PERCORRE TODOS OS ELEMENTOS DO ARRAY (SELECT)
	private function setParams($statement, $parameters = array()){

		foreach ($parameters as $key => $value) {
		
			$this->setParam($statement, $key, $value);

		}
	}

	// VINCULA DINAMICAMENTE OS ELEMENTOS DA QUERY
	private function setParam($statement, $key, $value){
		
		$statement->bindParam($key, $value);

	}	

	// EXECUTA OS VALORES PARAMETRIZADOS
	public function query($rawQuery, $params = array()){

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt;

		$this->conn = null;

	}

	// RETORNA A EXECUÇÃO SOLICITADA EM FORMATO DE ARRAY ASSOCIATIVO (SEM OS NÚMEROS INDICES)
	public function select($rawQuery, $params = array()):array {

		$stmt = $this->query($rawQuery, $params);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	}
    
}

?>