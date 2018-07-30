<?php
// VERIFICA SE EXISTEM ERROS DE EXECUÇÃO NO CÓDIGO
ini_set('display_errors',1); 

// FUNÇÃO QUE VERIFICA SE DETERMINADA CLASSE EXISTE E, EM CASO AFIRMATIVO, FAZ O REQUIRE DO ARQUIVO
spl_autoload_register(function($className){

	// CAMINHO PARA ACESSAR DO SERVIDOR DA CEOPC (TESTES)
	// $fileName = "class". DIRECTORY_SEPARATOR . $className . ".php";
	// CAMINHO FIXO
	$caminho = $_SERVER["DOCUMENT_ROOT"];
	$fileName = $caminho . DIRECTORY_SEPARATOR . "esteiracomex" . DIRECTORY_SEPARATOR . "email_cliente_esteira" . DIRECTORY_SEPARATOR . "class". DIRECTORY_SEPARATOR . $className . ".php";


	// 	require_once("DAO". DIRECTORY_SEPARATOR .$fileName);

	
	// CÓDIGO CHUMAN
	if(file_exists($fileName)) {

		require_once($fileName);

	}

});