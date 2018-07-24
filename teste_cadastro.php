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

        // CHAMA O ARQUIVO DE VERIFICAÇÃO DE EXISTÊNCIA DAS CLASSES
        require_once("config.php");

        $usuario = new Empregado();

        $empresa = new Empresa();

        $cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : "";

        // $cnpj = '69.193.175/0001-69';

        $empresa->loadByCnpj($cnpj);

        // echo $empresa;
    ?>

    <fieldset><legend>DADOS CADASTRAIS</legend>
    <form method="post">
    NOME: <input type="text" value="<?php echo $empresa->getNome(); ?>" readonly size="90">&nbsp;&nbsp;&nbsp;&nbsp;
    CNPJ: <input type="text" value="<?php echo $empresa->getCnpj(); ?>" readonly><br/><br/>
    E-MAIL PRINCIPAL: <input type="email" value="<?php echo $empresa->getEmailPrincipal(); ?>" name="emailPrincipal"size="111"><br/>
    E-MAIL SECUNDÁRIO: <input type="email" value="<?php echo $empresa->getEmailSecundario(); ?>" name="emailSecundario" size="108"><br/>
    E-MAIL RESERVA: <input type="email" value="<?php echo $empresa->getEmailReserva(); ?>" name="emailReserva" size="113"><br/>
    <input type="submit" value="ALTERAR CADASTRO">
    </form>
    </fieldset>


    <a href="index.php">Voltar</a>    
</body>
</html>