<?php  
// VERIFICA SE EXISTEM ERROS DE EXECUÇÃO NO CÓDIGO
ini_set('display_errors',1);
// setlocale(LC_ALL,'pt_BR.UTF8');
// mb_internal_encoding("UTF8"); 
// mb_regex_encoding('UTF8'); 


// CRIAÇÃO DA CLASSE
class Historico {

	// DEFINIÇÃO DOS ATRIBUTOS
	private $data;
	private $idEmpresa;
	private $cnpj;
	private $tipoAcao;
	private $area;
	private $nomeResponsavel;
	private $matriculaResponsavel;
	private $historico;

	// MÉTODOS
	
	// CONSTRUCT PARA SETTAR TODOS OS VALORES NO OBJETO, COM EXCEÇÃO DO HISTÓRICO
	public function __construct($objEmpresa, $objEmpregado){

		if ($objEmpregado->getLotacaoFisica() != 0) {
			$this->setArea($objEmpregado->getLotacaoFisica());
		} else {
			$this->setArea($objEmpregado->getLotacaoAdm());
		}
		$this->setIdEmpresa($objEmpresa->getIdEmpresa());
		$this->setCnpj($objEmpresa->getCnpj());
		$this->setNomeResponsavel($objEmpregado->getNome());
		$this->setMatriculaResponsavel($objEmpregado->getMatricula());
		$this->setData();
	}

	// MÉTODO PARA TRAZER OS DADOS DO OBJETO COMO JSON
	public function __toString(){

		return json_encode(array(
			"ID_EMPRESA"=>$this->getIdEmpresa(),
			"CNPJ"=>$this->getCnpj(),
			"DATA"=>$this->getData(),
			"ACAO"=>$this->getTipoAcao(),
			"NOME_RESPONSAVEL"=>$this->getNomeResponsavel(),
			"MATRICULA_RESPONSAVEL"=>$this->getMatriculaResponsavel(),
			"AREA_RESPONSAVEL"=>$this->getArea(),
			"HISTORICO"=>$this->getHistorico(),
		), JSON_UNESCAPED_SLASHES);

	}

	// GETTERS E SETTERS DOS ATRIBUTOS

	// $data
	public function getData(){
		return $this->data;
	}
	public function setData(){
		$this->data = date("Y-m-d H:i:s", time());
	}

	// $idEmpresa
	public function getIdEmpresa(){
		return $this->idEmpresa;
	}
	public function setIdEmpresa($value){
		$this->idEmpresa = $value;
	}

	// $cnpj
	public function getCnpj(){
		return $this->cnpj;
	}
	public function setCnpj($value){
		$this->cnpj = $value;
	}

	// $tipoAcao
	public function getTipoAcao(){
		return $this->tipoAcao;
	}
	public function setTipoAcao($value){
		$this->tipoAcao = $value;
	}

	// $area
	public function getArea(){
		return $this->area;
	}
	public function setArea($value){
		$this->area = $value;
	}

	// $nomeResponsavel
	public function getNomeResponsavel(){
		return $this->nomeResponsavel;
	}
	public function setNomeResponsavel($value){
		$this->nomeResponsavel = $value;
	}

	// $matriculaResponsavel
	public function getMatriculaResponsavel(){
		return $this->matriculaResponsavel;
	}
	public function setMatriculaResponsavel($value){
		$this->matriculaResponsavel = $value;
	}

	// $historico
	public function getHistorico(){
		return $this->historico;
	}
	public function setHistorico($emailPrincipal = "sem e-mail cadastrado", $emailSecundario = "sem e-mail cadastrado", $emailReserva = "sem e-mail cadastrado"){

		switch ($this->getTipoAcao()) {
			case 'ALTERACAO':
				
				if($emailPrincipal === NULL){
					$emailPrincipal = "sem e-mail cadastrado";
				}
				if($emailSecundario === NULL){
					$emailSecundario = "sem e-mail cadastrado";
				}
				if($emailReserva === NULL){
					$emailReserva = "sem e-mail cadastrado";
				}
				
				$this->historico = "Alteracao no Cadastro (e-mail principal: $emailPrincipal; e-mail secundario: $emailSecundario e e-mail reserva: $emailReserva).";
				break;
			
			case 'ENVIO':
				
				if($emailPrincipal === NULL){
					$emailPrincipal = "sem e-mail cadastrado";
				}
				if($emailSecundario === NULL){
					$emailSecundario = "sem e-mail cadastrado";
				}
				if($emailReserva === NULL){
					$emailReserva = "sem e-mail cadastrado";
				}
				
				$this->historico = "Ordem de Pagamento enviada (e-mail principal: $emailPrincipal; e-mail secundario: $emailSecundario e e-mail reserva: $emailReserva).";
				break;

		}

	}

	// MÉTODO QUE REGISTRA O HISTÓRICO NA TABELA tbl_SIEXC_OPES_EMAIL_HISTORICO E ATUALIZA O CADASTRO DA TABELA tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO
	public function registraHistoricoCadastro($objEmpresa, $objEmpregado){

		$sql = new Sql();
		//echo json_encode(get_class_methods($sql));
		$sql->beginTransaction();

		try {


			// REGISTRA O HISTÓRICO NA TABELA tbl_SIEXC_OPES_EMAIL_HISTORICO
			$registraHist = $sql->select("INSERT INTO [dbo].[tbl_SIEXC_OPES_EMAIL_HISTORICO]
											(
												[CNPJ]
												,[ACAO]
												,[HISTORICO]
												,[COD_MATRICULA]
												,[CO_PV]
											)
										VALUES
											(
												:CNPJ,
												:ACAO,
												:HISTORICO,
												:COD_MATRICULA,
												:CO_PV
											)", array(
												':CNPJ'=>$this->getCnpj(),
												':ACAO'=>$this->getTipoAcao(),
												':HISTORICO'=>$this->getHistorico(),
												':COD_MATRICULA'=>$this->getMatriculaResponsavel(),
												':CO_PV'=>$this->getArea()
										));
										
			// ATUALIZA O CADASTRO DA TABELA tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO
			$registraHist = $sql->query("UPDATE [dbo].[tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO]
										SET										
											[EMAIL_PRINCIPAL] = :EMAIL_PRINCIPAL
											,[EMAIL_SECUNDARIO] = :EMAIL_SECUNDARIO
											,[EMAIL_RESERVA] = :EMAIL_RESERVA
											,[MATRICULA_RESP] = :MATRICULA_RESP
											,[DATA_CADASTRO_EMAIL] = :DATA_CADASTRO_EMAIL
											,[NOME_RESP] = :NOME_RESP
										WHERE
											[CNPJ] = :CNPJ", array(
											':CNPJ'=>$objEmpresa->getCnpj(),
											':EMAIL_PRINCIPAL'=>$objEmpresa->getEmailPrincipal(),
											':EMAIL_SECUNDARIO'=>$objEmpresa->getEmailSecundario(),
											':EMAIL_RESERVA'=>$objEmpresa->getEmailReserva(),
											':DATA_CADASTRO_EMAIL'=>date("Y-m-d H:i:s"),
											':MATRICULA_RESP'=>$objEmpregado->getMatricula(),
											':NOME_RESP'=>$objEmpregado->getNome()												
										));
			$sql->commit();
		
		} catch(Exception $e) {

			$sql->rollback();

			// EM CASO DE ERRO, RETORNA O TIPO VIA JSON NA TELA
			echo json_encode(array(
				"message"=>$e->getMessage(),
				"line"=>$e->getLine(),
				"file"=>$e->getFile(),
				"code"=>$e->getCode()
			));
		}
	}

	// MÉTODO QUE REGISTRA O HISTÓRICO NA TABELA tbl_SIEXC_OPES_EMAIL_HISTORICO 
	public function registraHistoricoEnvioEmail(){

        // // ATRIBUI O TIPO DE AÇÃO A SER REGISTRADA NO HISTÓRICO
		// $this->setTipoAcao("ENVIO");

		// CRIA O OBJETO DE CONEXÃO AO BANCO DE DADOS
		$sql = new Sql();
		//echo json_encode(get_class_methods($sql));
		// $sql->beginTransaction();

		try {

			// REGISTRA O HISTÓRICO NA TABELA tbl_SIEXC_OPES_EMAIL_HISTORICO
			$registraHist = $sql->select("INSERT INTO [dbo].[tbl_SIEXC_OPES_EMAIL_HISTORICO]
											(
												[CNPJ]
												,[ACAO]
												,[HISTORICO]
												,[COD_MATRICULA]
												,[CO_PV]
											)
										VALUES
											(
												:CNPJ,
												:ACAO,
												:HISTORICO,
												:COD_MATRICULA,
												:CO_PV
											)", array(
												':CNPJ'=>$this->getCnpj(),
												':ACAO'=>$this->getTipoAcao(),
												':HISTORICO'=>$this->getHistorico(),
												':COD_MATRICULA'=>$this->getMatriculaResponsavel(),
												':CO_PV'=>$this->getArea()
										));
										
			// $sql->commit();
		
		} catch(Exception $e) {

			// $sql->rollback();

			// EM CASO DE ERRO, RETORNA O TIPO VIA JSON NA TELA
			echo json_encode(array(
				"message"=>$e->getMessage(),
				"line"=>$e->getLine(),
				"file"=>$e->getFile(),
				"code"=>$e->getCode()
			));
		}
	}

	// MÉTODO DE CONSULTA DAS 5 ÚLTIMAS MOVIMENTAÇÕES NO HISTÓRICO NAQUELE CNPJ
	public function consultaHistorico() {
		
		// CRIA O OBJETO DE CONEXÃO AO BANCO DE DADOS
		$sql = new Sql();

		try{

			$consulta = $sql->select("SELECT TOP 5
										[DATA_HISTORICO] AS [DATA]
										,[CNPJ]
										,[ACAO]
										,[HISTORICO]
										,[COD_MATRICULA]
										,[CO_PV]
									FROM
										[dbo].[tbl_SIEXC_OPES_EMAIL_HISTORICO]
									WHERE
										[CNPJ] = :CNPJ
									ORDER BY [COD_HISTORICO] DESC", array(
										':CNPJ'=>$this->getCnpj()
									));
			return json_encode($consulta, JSON_UNESCAPED_SLASHES);

		} catch (Exception $e) {

			echo json_encode(array(
				"message"=>$e->getMessage(),
				"line"=>$e->getLine(),
				"file"=>$e->getFile(),
				"code"=>$e->getCode()
			));

		}
	}
}

?>