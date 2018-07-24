<?php	
// VERIFICA SE EXISTEM ERROS DE EXECUÇÃO NO CÓDIGO
ini_set('display_errors',1);

// CRIAÇÃO DA CLASSE
class Empregado {
	
	// DEFINIÇÃO DOS ATRIBUTOS
	private $matricula; 
	private $nome;
	private $lotacaoAdm;
	private $lotacaoFisica;
	private $nivelAcesso;
	private $funcao;
	private $dataAdmissao;

	// MÉTODOS

	// GETTERS E SETTERS DOS ATRIBUTOS
	
	// $matricula
	public function getMatricula(){

		return $this->matricula;

	}
	public function setMatricula($value){

		$this->matricula = $value;

	}

	// $nome
	public function getNome(){

		return $this->nome;
	
	}
	public function setNome($value){

		$this->nome = $value;
		
	}

	// $lotacaoAdm
	public function getLotacaoAdm(){

		return $this->lotacaoAdm;

	}
	public function setLotacaoAdm($value){

		$this->lotacaoAdm = $value;
		
	}

	// $lotacaoFisica
	public function getLotacaoFisica(){

		return $this->lotacaoFisica;

	}
	public function setLotacaoFisica($value){

		$this->lotacaoFisica = $value;
		
	}

	// $nivelAcesso
	public function getNivelAcesso(){

		return $this->nivelAcesso;

	}
	public function setNivelAcesso($value){

		$this->nivelAcesso = $value;
		
	}

	// $funcao
	public function getFuncao(){

		return $this->funcao;

	}
	public function setFuncao($value){

		$this->funcao = $value;
		
	}

	// $dataAdmissao
	public function getDataAdmissao(){

		return $this->dataAdmissao;

	}
	public function setDataAdmissao($value){

		$this->dataAdmissao = $value;
		
	}

	// METODO MÁGICO PARA SETTAR TODOS OS ATRIBUTOS
	public function __construct(){
		
		// ATRIBUIÇÃO DA VARIÁVEL MATRÍCULA
		$this->setMatricula(substr($_SERVER["LOGON_USER"],strpos($_SERVER["LOGON_USER"], "\\")+1));

		$sql = new Sql();

		$result = $sql->select("SELECT 
									[MATRICULA]       
									,[DESCRICAO]       
									,[NIVEL]  
									,[UNIDADE]        
									,[GT_CONTRATACOES]
									, [COD_FUNCAO]   
								FROM 
									[tbl_ACESSA_EMPREGADO] 
								WHERE [MATRICULA] = :MATRICULA", array(
									':MATRICULA'=>$this->getMatricula(),
								));
		if(!empty($result)){

			$row = $result[0];
			// ATRIBUIÇÃO DAS VARIÁVEIS LOTAÇÃO_ADM E NÍVEL DE ACESSO
			$this->setLotacaoAdm($row['UNIDADE']);
			$this->setNivelAcesso($row['NIVEL']);

		}

		$capturaDadosBanco = $sql->select("SELECT 
												[MATRICULA]
												,[NOME]
												,[DATA_CONTRATACAO]
												,[CODIGO_FUNCAO]
												,[FUNCAO]
												,[CODIGO_UNIDADE_LOTACAO_ADMINISTRATIVA]
												,[UNIDADE_LOTACAO_ADMINISTRATIVA]
												,[UF_UNIDADE_ADMINISTRATIVA]
												,[CODIGO_UNIDADE_LOTACAO_FISICA]
												,[UNIDADE_LOTACAO_FISICA]
											FROM 
												[EMPREGADOS]
											WHERE
												MATRICULA = '" . str_replace("c","", $this->getMatricula() . "'")
											);
		
		if(!empty($capturaDadosBanco)){

			$row2 = $capturaDadosBanco[0];

			// ATRIBUIÇÃO DAS VARIÁVEIS NOME, LOTAÇÃO_FISICA, FUNÇÃO E DATA_CONTRATAÇÃO
			$this->setNome($row2['NOME']);
			$this->setLotacaoFisica($row2['CODIGO_UNIDADE_LOTACAO_FISICA']);
			$this->setFuncao($row2['FUNCAO']);
			$this->setDataAdmissao($row2['DATA_CONTRATACAO']);

		}

	}

	// MÉTODO PARA TRAZER OS DADOS DO OBJETO COMO JSON
	public function __toString(){

		return json_encode(array(
			"MATRICULA"=>$this->getMatricula(),
			"NOME"=>$this->getNome(),
			"LOTACAO_ADMINISTRATIVA"=>$this->getLotacaoAdm(),
			"LOTACAO_FISICA"=>$this->getLotacaoFisica(),
			"NIVEL_ACESSO"=>$this->getNivelAcesso(),
			"FUNCAO"=>$this->getFuncao(),
			"DATA_ADMISSAO"=>$this->getDataAdmissao(),
		), JSON_UNESCAPED_SLASHES);

	}
	
}

?>