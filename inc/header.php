<?php
session_start();
isset($_SESSION['tipoProfessor']) ? $tipoProf = $_SESSION['tipoProfessor'] : $tipoProf = "";
include("../integracao/loginFunc.php");
lidaBasicAuthentication('../../portal/naoautorizado.php');

/* if(!isset($_SESSION['codProfessor']) || (!is_numeric($_SESSION['codProfessor']))){
    echo '<br><br><br><center>Acesso Negado';
    exit();
} */
ini_set('default_charset', 'ISO-8859-1');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO-8859-1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SenaQuiz</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/estilo.css">
        <script src="../js/javascript.js"></script>
    </head>
    <body>
        <?php 
        $show = isset($_SESSION['showMenu']) ? $_SESSION['showMenu'] : false;
        if($show) { ?>
        <nav role="navigation" class="navbar navbar-default ">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                        <span class="sr-only">Navegação Responsiva</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand">Projeto Integrador II</span>
                </div>
                <div id="navbarCollapse" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="../area">&Aacute;reas</a></li>
                        <li><a href="../assunto">Assuntos</a></li>
                        <li><a href="../questao">Quest&otilde;es</a></li>
                        <li><a href="../professor">Professores</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
         <?php } ?> 
<?php
include("modals.php");
?>

<br>