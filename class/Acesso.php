<?php
// VERIFICA SE EXISTEM ERROS DE EXECUÇÃO NO CÓDIGO
ini_set('display_errors',1);

class Acesso {

    private $tipoAcao;
    private $paginaAcessada;

    public function getTipoAcao(){

        return $this->tipoAcao;

    }
    public function setTipoAcao($tipoAcao){

        $this->tipoAcao = $tipoAcao;

    }

    public function getPaginaAcessada(){

        return $this->paginaAcessada;

    }
    public function setPaginaAcessada($paginaAcessada){

        $this->paginaAcessada = $paginaAcessada;

    }

    public function __construct($tipoAcao, $paginaAcessada){

        $this->setTipoAcao($tipoAcao);
        $this->setPaginaAcessada($paginaAcessada);

    }

    public function registraAcessoPagina($objEmpregado){

        $sql = new Sql();

        $sql->beginTransaction();

        try {

            $registraAcesso = $sql->query("INSERT INTO [dbo].[tbl_LOG_ACESSOS] 
                            (
                                [CO_MATRICULA]
                                ,[CO_TIPO]
                                ,[CO_PAGINA]
                                ,[CO_DATA]
                            )
                        VALUES
                            (
                                :MATRICULA,
                                :TIPO_ACAO,
                                :PAGINA_ACESSADA,
                                :DATA_ACESSO
                            )", array(
                                ':MATRICULA'=>$objEmpregado->getMatricula(),
                                ':TIPO_ACAO'=>$this->getTipoAcao(),
                                ':PAGINA_ACESSADA'=>$this->getPaginaAcessada(),
                                ':DATA_ACESSO'=>date("d/m/Y G:i:s")
                            ));
                            echo "<p>Dados utilizados: <br/>Matricula - " . $objEmpregado->getMatricula() . " <br/>Ação - " . $this->getTipoAcao() . " <br/>Página acessada - ". $this->getPaginaAcessada() ." <br/>Data - " . date("d/m/Y G:i:s") . ". </p>";
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
}

?>