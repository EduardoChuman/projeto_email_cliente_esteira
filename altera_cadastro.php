<?php
	// VERIFICA SE EXISTEM ERROS DE EXECUÇÃO NO CÓDIGO
	ini_set('display_errors',1);

    // CAPTURAR A RAIZ DO SERVIDOR
    // $caminho = $_SERVER["DOCUMENT_ROOT"];

    // CHAMA O ARQUIVO DE VERIFICAÇÃO DE EXISTÊNCIA DAS CLASSES
    // require_once($caminho . DIRECTORY_SEPARATOR . "esteiracomex" . DIRECTORY_SEPARATOR . "email_cliente_esteira" . DIRECTORY_SEPARATOR . "config.php");
    require_once("config.php");

    try{
        // CAPTURA AS VARIÁVEIS RECEBIDAS VIA POST E ATRIBUI AS VARIÁVEIS
        $nomeEmpresa = $_POST['nomeEmpresa'];
        $cnpjEmpresa = $_POST['cnpjEmpresa'];
        $emailPrincipal = filter_input(INPUT_POST, 'emailPrincipal', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_SANITIZE_EMAIL);
        $emailSecundario = filter_input(INPUT_POST, 'emailSecundario', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_SANITIZE_EMAIL);
        $emailReserva = filter_input(INPUT_POST, 'emailReserva', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_SANITIZE_EMAIL);

        // SETTAR VALOR NULL PARA VARIÁVEIS VAZIAS
        if($emailPrincipal == ""){
            $emailPrincipal = NULL;
        }
        if($emailSecundario == ""){
            $emailSecundario = NULL;
        }
        if($emailReserva == ""){
            $emailReserva = NULL;
        }

        // CRIA OS OBJETOS DAS CLASSES EMPREGADO e EMPRESA
        $usuario = new Empregado();
        $empresa = new Empresa();
        
        // ATRIBUI OS VALORES DAS VARIÁVEIS AOS ATRIBUTOS DO OBJETO EMPRESA
        $empresa->setNome($nomeEmpresa);
        $empresa->setCnpj($cnpjEmpresa);
        $empresa->setEmailPrincipal($emailPrincipal);
        $empresa->setEmailSecundario($emailSecundario);
        $empresa->setEmailReserva($emailReserva);
        
        // CRIA O OBJETO HISTÓRICO
        $historico = new Historico($empresa, $usuario);


        // ATRIBUI O TIPO DE AÇÃO A SER REGISTRADA NO HISTÓRICO
        $historico->setTipoAcao("ALTERACAO");
        
        // CRIA A LINHA QUE VAI NO HISTÓRICO DA TABELA tbl_SIEXC_OPES_EMAIL_HISTORICO
        $historico->setHistorico($emailPrincipal, $emailSecundario, $emailReserva);


        // REGISTRA O HISTÓRICO NA TABELA tbl_SIEXC_OPES_EMAIL_HISTORICO E ATUALIZA O CADASTRO DA TABELA tbl_SIEXC_OPES_EMAIL_CLIENTES_CADASTRO
        $historico->registraHistoricoCadastro($empresa, $usuario);

        // DEVOLVER PARA A PÁGINA DE CADASTRO DE EMAIL
        header("location:http://www.ceopc.hom.sp.caixa/esteiracomex/cadastro_email_cliente_comex.php");

    } catch (Exception $e) {

        // EM CASO DE ERRO, RETORNA O TIPO VIA JSON NA TELA
        echo json_encode(array(
            "message"=>$e->getMessage(),
            "line"=>$e->getLine(),
            "file"=>$e->getFile(),
            "code"=>$e->getCode()
        ));

    }

?>
<br/>
<!-- RETORNA PARA A TELA INICIAL
<a href="index.php">Voltar</a>   -->