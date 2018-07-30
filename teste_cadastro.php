<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastro de Clientes</title>
</head>
<body>
    <?php
        // VERIFICA SE EXISTEM ERROS DE EXECUÇÃO NO CÓDIGO
        ini_set('display_errors',1);
        // setlocale(LC_ALL,'pt_BR.UTF8');
        // mb_internal_encoding('UTF8'); 
        // mb_regex_encoding('UTF8'); 

        // CAPTURAR A RAIZ DO SERVIDOR
        // $caminho = $_SERVER["DOCUMENT_ROOT"];
        // CHAMA O ARQUIVO DE VERIFICAÇÃO DE EXISTÊNCIA DAS CLASSES
        // require_once($caminho . DIRECTORY_SEPARATOR . "esteiracomex" . DIRECTORY_SEPARATOR . "email_cliente_esteira" . DIRECTORY_SEPARATOR . "config.php");
        require_once("config.php");


        // CRIA OS OBJETOS DE EMPREGADO E EMPRESA
        $usuario = new Empregado();
        $empresa = new Empresa();

        // ATRIBUI VALOR A VARIÁVEL
        $id = isset($_POST['id']) ? $_POST['id'] : "";

        // RETORNA A EMPRESA QUE CONTÉM AQUELE ID
        $empresa->loadById($id);

    ?>

    <!-- FORMULÁRIO PARA CADASTRAR NOVA RELAÇÃO DE E-MAIL -->
    <fieldset><legend>DADOS CADASTRAIS</legend>
    <form method="post" action="altera_cadastro.php">
    NOME: <input type="text" name="nomeEmpresa" value="<?php echo $empresa->getNome(); ?>" readonly size="90">&nbsp;&nbsp;&nbsp;&nbsp;
    CNPJ: <input type="text" name="cnpjEmpresa" value="<?php echo $empresa->getCnpj(); ?>" readonly><br/><br/>
    E-MAIL PRINCIPAL: <input type="email" name="emailPrincipal" value="<?php echo $empresa->getEmailPrincipal(); ?>" size="111"><br/>
    E-MAIL SECUNDÁRIO: <input type="email" name="emailSecundario" value="<?php echo $empresa->getEmailSecundario(); ?>" size="108"><br/>
    E-MAIL RESERVA: <input type="email" name="emailReserva"value="<?php echo $empresa->getEmailReserva(); ?>" size="113"><br/>
    <input type="submit" value="ALTERAR CADASTRO">
    </form>
    </fieldset>

    <!-- RETORNA PARA A TELA INICIAL -->
    <a href="index.php">Voltar</a>    
</body>
</html>