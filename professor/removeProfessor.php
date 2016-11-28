<?php
include("../config.php");



$id = $_GET['remover'];
$integridade = odbc_exec($db, "SELECT * FROM Questao WHERE codProfessor = $id");
var_dump($id);

$sql = "DELETE FROM Professor WHERE codProfessor = $id";

//$query = odbc_exec($db, $sql);

if(isset($_GET['remover']) && is_numeric($_GET['remover'])){
    if(odbc_num_rows($integridade) > 0){
        header("Location: index.php?relacionado=true");
    }else if(odbc_exec($db, $sql)){
        header("Location: index.php?removido=true");
    }
}
