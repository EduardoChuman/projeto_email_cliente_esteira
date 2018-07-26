<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home</title>
</head>
<body>
	<?php 
	// VERIFICA SE EXISTEM ERROS DE EXECUÇÃO NO CÓDIGO
	ini_set('display_errors',1);
	// setlocale(LC_ALL,'pt_BR.UTF8');
	// mb_internal_encoding('UTF8'); 
	// mb_regex_encoding('UTF8'); 

	// CHAMA O ARQUIVO DE VERIFICAÇÃO DE EXISTÊNCIA DAS CLASSES
	require_once("config.php");
	
	//CRIA UM OBJETO SQL
	// $sql = new Sql();
	// SOLICITA UM SELECT AO BANCO
	// $usuarios = $sql->select("SELECT 
	// 							NOME_CLIENTE
	// 							,[CPF/CNPJ]
	// 							,[EMAIL_PRINCIPAL]
	// 							,[EMAIL_SECUNDARIO]
	// 							,[EMAIL_RESERVA] 
	// 						FROM 
	// 							tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO");
	// echo json_encode($usuarios, JSON_UNESCAPED_SLASHES);

	// CARREGA UMA LISTA COM TODAS AS EMPRESAS
	// $lista = Empresa::getEmpresas();
	// echo json_encode($lista);

	//CARREGA UMA LISTA DE EMPRESA COM BASE EM UMA "TAG" DE BUSCA
	// $search = Empresa::search("GILVAN");
	// echo json_encode($search);

	//ATUALIZA UM NOVO E-MAIL NO CADASTRO DA EMPRESA
	// $inserir = new Empresa();
	// // $inserir->loadByCnpj('04.565.932/0001-32');
	// // echo "<br>";
	// $inserir->updateEmail('04.565.932/0001-32','edu.chuman@hotmail.com','eduardo.chuman@gmail.com','eduardo.chuman@caixa.gov.br');
	// echo "<br>";
	// echo $inserir;

	// CRIAÇÃO DO OBJETO EMPREGADO
	// $usuario = new Empregado();
	// echo $usuario;


	// ROTA PARA ACESSAR A LISTA DE EMPRESAS
	
	// CRIAÇÃO DO OBJETO EMPREGADO
	// $usuario = new Empregado();
	
	// CRIA UM OBJETO EMPRESA
	// $pv = new Empresa();

	// // FUNÇÃO PARA SETTAR A RELAÇÃO DAS EMPRESAS COM BASE NO PERFIL DE ACESSO, LOTAÇÃO FÍSICA OU LOTAÇÃO ADMINISTRATIVA
	// $pv->getEmpresas($usuario);

	//FUNÇÃO PARA TRAZER EM JSON A RELAÇÃO DE EMPRESAS DISPONÍVEIS
	// echo json_encode($pv->getListaEmpresa(), JSON_UNESCAPED_SLASHES);
	

	// SIMULAÇÃO DE COMO REALIZAR O REGISTRO DE UM HISTÓRICO
	//$hist = new Historico($pv, $usuario);

	//$hist->setHistorico("edu.chuman@hotmail.com");
	//echo $hist;

	?>
	<!-- INICIO DO FORMULÁRIO DE CAPTURA DE ID -->
	<form method="post" action="teste_cadastro.php">
		<fieldset><legend>Digite o ID para acesar o cadastro de e-mails</legend>
		ID: <input type="text" name="id" required>
		<input type="submit" value="PESQUISAR">
		</fieldset>
	</form>
	<!-- FIM DO FORMULÁRIO DE CAPTURA DE ID -->

</body>
</html>
