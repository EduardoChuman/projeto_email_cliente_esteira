<?php  
// VERIFICA SE EXISTEM ERROS DE EXECUÇÃO NO CÓDIGO
ini_set('display_errors',1);

// REALIZA O REQUIRE DA CLASSE USUÁRIO
// require_once("class" . DIRECTORY_SEPARATOR . "Empregado.php");

// CRIAÇÃO DA CLASSE
class Empresa {

	// DEFINIÇÃO DOS ATRIBUTOS
	private $idEmpresa;
	private $nome;
	private $cnpj;
	private $emailPrincipal;
	private $emailSecundario;
	private $emailReserva;
	private $codPv;
	private $codSr;
	private $listaEmpresa;


	// GETTERS E SETTERS DAS VARIÁVEIS DA CLASSE
	
	// $idEmpresa
	public function getIdEmpresa(){
		return $this->idEmpresa;
	}
	public function setIdEmpresa($value){
		$this->idEmpresa = $value;
	}

	// $nome
	public function getNome(){
		return $this->nome;
	}
	public function setNome($value){
		$this->nome = $value;
	}

	// $cnpj
	public function getCnpj(){
		return $this->cnpj;
	}
	public function setCnpj($value){
		$this->cnpj = $value;
	}

	// $emailPrincipal
	public function getEmailPrincipal(){
		return $this->emailPrincipal;
	}
	public function setEmailPrincipal($value){
		$this->emailPrincipal = $value;
	}

	// $emailSecundario
	public function getEmailSecundario(){
		return $this->emailSecundario;
	}
	public function setEmailSecundario($value){
		$this->emailSecundario = $value;
	}

	// $emailReserva
	public function getEmailReserva(){
		return $this->emailReserva;
	}
	public function setEmailReserva($value){
		$this->emailReserva = $value;
	}

	// $codPv
	public function getCodPv(){
		return $this->codPv;
	}
	public function setCodPv($value){
		$this->codPv = $value;
	}

	// $codSr
	public function getCodSr(){
		return $this->codSr;
	}
	public function setCodSr($value){
		$this->codSr = $value;
	}

	// $listaEmpresa
	public function getListaEmpresa(){
		return $this->listaEmpresa;
	}
	public function setListaEmpresa($value){
		$this->listaEmpresa = $value;
	}

	// FUNÇÃO QUE TRAZ A PRIMEIRA OCORRENCIA DO SELECT (NÃO FUNCIONA PARA TRAZER AS EMPRESAS)
	// public function loadByPv($codPv){

	// 	$sql = new Sql();

	// 	$result = $sql->select("SELECT 
	// 								[NOME_CLIENTE]
	// 								,[CNPJ]
	// 								,[EMAIL_PRINCIPAL]
	// 								,[EMAIL_SECUNDARIO]
	// 								,[EMAIL_RESERVA] 
	// 							FROM 
	// 								tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO
	// 							WHERE
	// 								[CO_PV] = :PV", array(":PV"=>$codPv));
	// 	if(count($result) > 0){

	// 		$row = $result[0];

	// 		$this->setNome($row['NOME_CLIENTE']);
	// 		$this->setCnpj($row['CPF/CNPJ']);
	// 		$this->setEmailPrincipal($row['EMAIL_PRINCIPAL']);
	// 		$this->setEmailSecundario($row['EMAIL_SECUNDARIO']);
	// 		$this->setEmailReserva($row['EMAIL_RESERVA']);

	// 	}
	// }

	// RETORNA OS VALORES DOS ATRIBUTOS EM UM JSON
	public function __toString(){

		return json_encode(array(
			"ID_CLIENTE"=>$this->getIdEmpresa(),
			"NOME_CLIENTE"=>$this->getNome(),
			"CPF/CNPJ"=>$this->getCnpj(),
			"EMAIL_PRINCIPAL"=>$this->getEmailPrincipal(),
			"EMAIL_SECUNDARIO"=>$this->getEmailSecundario(),
			"EMAIL_RESERVA"=>$this->getEmailReserva(),
		), JSON_UNESCAPED_SLASHES);
	}

	//FUNÇÃO PARA TRAZER TODOS OS RESULTADOS DA TABELA COM BASE NOS PARAMETROS DA CLASSE EMPREGADO.PHP
	public function getEmpresas($usuario){

		// SIMULAR OUTRO PERFIL DE ACESSO
		// if ($usuario->getMatricula() == 'c111710') {
			
		// 	$usuario->setNivelAcesso('100');
		// 	$usuario->setLotacaoFisica('1599');
		// 	$usuario->setLotacaoAdm('1599');

		// }

		// VERIFICA O NÍVEL DE ACESSO
		switch ($usuario->getNivelAcesso()) {

			// PERFIL AGÊNCIA
			case '100':
			
				// VERIFICA SE O USUÁRIO ESTÁ DESTACADO EM OUTRA UNIDADE
				if($usuario->getLotacaoFisica() != 0) {

					$sql = new Sql();

					$result =  $sql->select("SELECT DISTINCT
												CADASTRO.[ID_EMPRESA]
												,CADASTRO.[NOME_CLIENTE]
												,CADASTRO.[CNPJ]
												,CADASTRO.[EMAIL_PRINCIPAL]
												,CADASTRO.[EMAIL_SECUNDARIO]
												,CADASTRO.[EMAIL_RESERVA]
												,CADASTRO.[CO_PV]
												,UNIDADES.[NO_AG] AS [NO_PV]
											FROM 
												[tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO] AS CADASTRO
												LEFT JOIN [tbl_UNIDADES_DIRE] AS UNIDADES 
												ON CADASTRO.[CO_PV] = UNIDADES.[CD_AG]
											WHERE
												[CO_PV] = :COD", array(
													':COD'=>$usuario->getLotacaoFisica()
												));

					// echo json_encode($result, JSON_UNESCAPED_SLASHES);
					$this->setListaEmpresa($result);

				} else {

					$sql = new Sql();

					$result =  $sql->select("SELECT DISTINCT
												CADASTRO.[ID_EMPRESA]
												,CADASTRO.[NOME_CLIENTE]
												,CADASTRO.[CNPJ]
												,CADASTRO.[EMAIL_PRINCIPAL]
												,CADASTRO.[EMAIL_SECUNDARIO]
												,CADASTRO.[EMAIL_RESERVA]
												,CADASTRO.[CO_PV]
												,UNIDADES.[NO_AG] AS [NO_PV]
											FROM 
												[tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO] AS CADASTRO
												LEFT JOIN [tbl_UNIDADES_DIRE] AS UNIDADES 
												ON CADASTRO.[CO_PV] = UNIDADES.[CD_AG]
											WHERE
												[CO_PV] = :COD", array(
													':COD'=>$usuario->getLotacaoAdm()
												));

					// echo json_encode($result, JSON_UNESCAPED_SLASHES);
					$this->setListaEmpresa($result);
				}
				break;
		
			// PERFIL SR
			case '300':

				// VERIFICA SE O USUÁRIO ESTÁ DESTACADO EM OUTRA UNIDADE
				if($usuario->getLotacaoFisica() != 0) {

					$sql = new Sql();

					$result =  $sql->select("SELECT DISTINCT
												CADASTRO.[ID_EMPRESA]
												,CADASTRO.[NOME_CLIENTE]
												,CADASTRO.[CNPJ]
												,CADASTRO.[EMAIL_PRINCIPAL]
												,CADASTRO.[EMAIL_SECUNDARIO]
												,CADASTRO.[EMAIL_RESERVA]
												,CADASTRO.[CO_PV]
												,UNIDADES.[NO_AG] AS [NO_PV]
											FROM 
												[tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO] AS CADASTRO
												LEFT JOIN [tbl_UNIDADES_DIRE] AS UNIDADES 
												ON CADASTRO.[CO_PV] = UNIDADES.[CD_AG]
											WHERE
												[CO_SR] = :COD", array(
													':COD'=>$usuario->getLotacaoFisica()
												));

					// echo json_encode($result, JSON_UNESCAPED_SLASHES);
					$this->setListaEmpresa($result);

				} else {

					$sql = new Sql();

					$result =  $sql->select("SELECT DISTINCT
												CADASTRO.[ID_EMPRESA]
												,CADASTRO.[NOME_CLIENTE]
												,CADASTRO.[CNPJ]
												,CADASTRO.[EMAIL_PRINCIPAL]
												,CADASTRO.[EMAIL_SECUNDARIO]
												,CADASTRO.[EMAIL_RESERVA]
												,CADASTRO.[CO_PV]
												,UNIDADES.[NO_AG] AS [NO_PV]
											FROM 
												[tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO] AS CADASTRO
												LEFT JOIN [tbl_UNIDADES_DIRE] AS UNIDADES 
												ON CADASTRO.[CO_PV] = UNIDADES.[CD_AG]
											WHERE
												[CO_SR] = :COD", array(
													':COD'=>$usuario->getLotacaoAdm()
												));

					// echo json_encode($result, JSON_UNESCAPED_SLASHES);
					$this->setListaEmpresa($result);
				}
				break;
			
			// DEMAIS PERFIS
			default:

				$sql = new Sql();

				$result =  $sql->select("SELECT DISTINCT
											CADASTRO.[ID_EMPRESA]
											,CADASTRO.[NOME_CLIENTE]
											,CADASTRO.[CNPJ]
											,CADASTRO.[EMAIL_PRINCIPAL]
											,CADASTRO.[EMAIL_SECUNDARIO]
											,CADASTRO.[EMAIL_RESERVA]
											,CADASTRO.[CO_PV]
											,UNIDADES.[NO_AG] AS [NO_PV]
										FROM 
											[tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO] AS CADASTRO
											LEFT JOIN [tbl_UNIDADES_DIRE] AS UNIDADES 
											ON CADASTRO.[CO_PV] = UNIDADES.[CD_AG]"
										);

				// echo json_encode($result, JSON_UNESCAPED_SLASHES);
				$this->setListaEmpresa($result);
		}
		
	}

	// FUNÇÃO PARA RETORNAR O RESULTADO DE UM SEARCH
	public static function search($empresa){

		$sql = new Sql();

		return $sql->select("SELECT 
								[ID_EMPRESA] 
								,[NOME_CLIENTE]
								,[CNPJ]
								,[EMAIL_PRINCIPAL]
								,[EMAIL_SECUNDARIO]
								,[EMAIL_RESERVA]
								,[CO_PV] 
							FROM 
								tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO
							WHERE
								[NOME_CLIENTE] LIKE :SEARCH", array(':SEARCH'=>"%" . $empresa . "%"));	

	}


	// FUNÇÃO QUE TRAZ TODOS OS RESULTADOS DE UM SELECT COM WHERE NO CO_PV (TRAZ TODOS OS REGISTROS DA AGÊNCIA)
	public function loadByPv($usuario){

		// SIMULAR OUTRO PERFIL DE ACESSO
		// if ($usuario->getMatricula() == 'c111710') {
			
		// 	$usuario->setLotacaoFisica('1599');
		// 	$usuario->setLotacaoAdm('1599');

		// }
		
		$sql = new Sql();

		$result = $sql->select("SELECT 
									[ID_EMPRESA] 
									,[NOME_CLIENTE]
									,[CNPJ]
									,[EMAIL_PRINCIPAL]
									,[EMAIL_SECUNDARIO]
									,[EMAIL_RESERVA] 
								FROM 
									tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO
								WHERE
									[CO_PV] = :PV", array(":PV"=>$usuario->getLotacaoAdm()));

		// echo json_encode($result, JSON_UNESCAPED_SLASHES);
		$this->setListaEmpresa($result);

	}

	// FUNÇÃO QUE TRAZ TODOS OS RESULTADOS DE UM SELECT COM WHERE NO CO_SR (TRAZ TODOS OS REGISTROS DA SUPERITENDÊNCIA)
	public function loadBySr($usuario){

		// SIMULAR OUTRO PERFIL DE ACESSO
		// if ($usuario->getMatricula() == 'c111710') {
			
		// 	$usuario->setLotacaoFisica('1599');
		// 	$usuario->setLotacaoAdm('1599');

		// }

		$sql = new Sql();

		$result = $sql->select("SELECT 
									[ID_EMPRESA] 
									,[NOME_CLIENTE]
									,[CNPJ]
									,[EMAIL_PRINCIPAL]
									,[EMAIL_SECUNDARIO]
									,[EMAIL_RESERVA] 
									,[CO_PV] 
								FROM 
									tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO
								WHERE
									[CO_SR] = :SR", array(":SR"=>$usuario->getLotacaoAdm()));

		// echo json_encode($result, JSON_UNESCAPED_SLASHES);
		$this->setListaEmpresa($result);

	}
	// FUNÇÃO QUE TRAZ TODOS OS RESULTADOS DE UM SELECT COM WHERE NO [CPF/CNPJ]
	public function loadById($id){

		$this->setIdEmpresa($id);

		$sql = new Sql();

		$result = $sql->select("SELECT 
									[ID_EMPRESA] 
									,[NOME_CLIENTE]
									,[CNPJ]
									,[EMAIL_PRINCIPAL]
									,[EMAIL_SECUNDARIO]
									,[EMAIL_RESERVA] 
								FROM 
									tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO
								WHERE
									[ID_EMPRESA]= :ID", array(":ID"=>$this->getIdEmpresa()));
		
		//echo json_encode($result, JSON_UNESCAPED_SLASHES);
		// var_dump($result);
		
		// VERIFICA SE O RESULT RETORNOU RESULTADO
		if(!empty($result)){

			$row = $result[0];
			// ATRIBUIÇÃO DAS VARIÁVEIS 
			$this->setNome($row['NOME_CLIENTE']);
			$this->setCnpj($row['CNPJ']);
			$this->setEmailPrincipal($row['EMAIL_PRINCIPAL']);
			$this->setEmailSecundario($row['EMAIL_SECUNDARIO']);
			$this->setEmailReserva($row['EMAIL_RESERVA']);

		}		

	}

	// FUNÇÃO QUE TRAZ A RELAÇÃO DE TODAS AS EMPRESAS DE UM PV OU SR
	public function loadByPvOuSr($usuario){

		// SIMULAR OUTRO PERFIL DE ACESSO
		// if ($usuario->getMatricula() == 'c111710') {
			
		// 	$usuario->setLotacaoFisica('1599');
		// 	$usuario->setLotacaoAdm('1599');

		// }

		$sql = new Sql();

		// PRIMEIRO REALIZA UM SELECT POR PV
		$result = $sql->select("SELECT 
									[ID_EMPRESA] 
									,[NOME_CLIENTE]
									,[CNPJ]
									,[EMAIL_PRINCIPAL]
									,[EMAIL_SECUNDARIO]
									,[EMAIL_RESERVA] 
								FROM 
									tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO
								WHERE
									[CO_PV] = :PV", array(":PV"=>$usuario->getLotacaoAdm()));
		
		/*
			AQUI VERIFICA QUE O SELECT RETORNOU ALGUM RESULTADO. CASO: 

			POSITIVO: ELE TRARÁ UM JSON DO SELECT;
			NEGATIVO: ELE PARTIRÁ PARA O PRÓXIMO SELECT (SR);
		
		*/
		if (!empty($result)) {
		 	
			// echo json_encode($result, JSON_UNESCAPED_SLASHES);
			$this->setListaEmpresa($result);
		
		} else {
			
			// REALIZAÇÃO DO SELECT POR SR
			$result = $sql->select("SELECT 
										[ID_EMPRESA] 
										,[NOME_CLIENTE]
										,[CNPJ]
										,[EMAIL_PRINCIPAL]
										,[EMAIL_SECUNDARIO]
										,[EMAIL_RESERVA] 
										,[CO_PV] 
									FROM 
										tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO
									WHERE
										[CO_SR] = :SR", array(":SR"=>$usuario->getLotacaoAdm()));
		
		/*
			AQUI VERIFICA QUE O SELECT RETORNOU ALGUM RESULTADO. CASO: 

			POSITIVO: ELE TRARÁ UM JSON DO SELECT;
			NEGATIVO: ELE DEVOLVERÁ UMA MENSAGEM DE ERRO;
		
		*/
			if (!empty($result)) {

				// echo json_encode($result, JSON_UNESCAPED_SLASHES);
				$this->setListaEmpresa($result);

			} 

		} if (empty($result)) {

			echo "Não existem empresas cadastradas nesse ponto de atendimento.";

		}

	}

	// METÓDO QUE RETORNA A QUANTIDADE DE EMPRESAS COM E-MAIL CADASTRADO QUE TEM OP(s) PARA ENVIAR
	public function listaEmpresasEnvioEmail(){

		// CRIA O OBJETO DE CONEXÃO COM O BANCO DE DADOS
		$sql = new Sql();

		// REALIZA UM SELECT QUE LISTA AS EMPRESAS COM E-MAIL QUE TEM OPO(s) PARA ENVIAR
		$result = $sql->select("SELECT DISTINCT
									CADASTRO.[NOME_CLIENTE]
									,CADASTRO.[CNPJ]
									,CADASTRO.[EMAIL_PRINCIPAL]
									,CADASTRO.[EMAIL_SECUNDARIO]
									,CADASTRO.[EMAIL_RESERVA]
								FROM 
									[tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO] AS CADASTRO 
									INNER JOIN [tbl_SIEXC_OPES_ENVIADAS]  AS OPES 
									ON CADASTRO.[CNPJ] = OPES.[CPF/CNPJ do Cliente]
								WHERE  
									OPES.[DATA_ENVIO_OPE] is NULL AND CADASTRO.[EMAIL_PRINCIPAL] IS NOT NULL
									OR OPES.[DATA_ENVIO_OPE] is NULL AND CADASTRO.[EMAIL_SECUNDARIO] IS NOT NULL
									OR OPES.[DATA_ENVIO_OPE] is NULL AND CADASTRO.[EMAIL_RESERVA] IS NOT NULL");
		
		// VERIFICA SE RETORNOU ALGUM OBJETO NO SELECT
		if (!empty($result)) {

			// CASO POSITIVO -> ELE DEVOLVE NA TELA COMO JSON EM FORMATO DE OBJETO
			// return json_encode($result, JSON_FORCE_OBJECT);
			// $this->setListaEmpresa($result);
			return $result;

		} // else {

		// 	// CASO NEGATIVO -> AVISA QUE NÃO EXISTEM EMPRESAS PARA ENVIAR E-MAIL
		// 	return "Não existem empresas cadastradas nesse ponto de atendimento.";

		// }

	}

}

?>