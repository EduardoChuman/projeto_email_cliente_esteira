<?php
// VERIFICA SE EXISTEM ERROS DE EXECUÇÃO NO CÓDIGO
ini_set('display_errors',1); 

// FUNÇÃO QUE VERIFICA SE DETERMINADA CLASSE EXISTE E, EM CASO AFIRMATIVO, FAZ O REQUIRE DO ARQUIVO
spl_autoload_register(function($className){

	$fileName = "class". DIRECTORY_SEPARATOR . $className . ".php";
	// TESTES VLAD
	// if(file_exists("DAO". DIRECTORY_SEPARATOR .$fileName)) {

	// 	require_once("DAO". DIRECTORY_SEPARATOR .$fileName);

	
	// CÓDIGO CHUMAN
	if(file_exists($fileName)) {

		require_once($fileName);

	}

});