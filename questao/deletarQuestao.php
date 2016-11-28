<?php
include("../config.php");

function queryExec($sql){
	global $db;
	return odbc_exec($db, $sql);
}
if(isset($_GET['remover'])){
	$id = $_GET['remover'];
	
    if(is_numeric($id)){
        $query = "SELECT codQuestao FROM questaoEvento WHERE codQuestao = {$id}";
        $result = queryExec($query);

        if(odbc_num_rows($result) > 0){
                $desQuestao = "UPDATE Questao SET Ativo = 0 WHERE codQuestao = {$id}";
                $exec = queryExec($desQuestao);
                echo "questao desativada";
				header("Location: index.php?desativada=true");
        } else{
            $removeAlternativa = "DELETE FROM alternativa WHERE codQuestao = {$id}";
            queryExec($removeAlternativa);

            $removeQuestao = "DELETE FROM questao OUTPUT deleted.codImagem WHERE codQuestao = {$id}";
            $ar = queryExec($removeQuestao);

            if(odbc_fetch_array($ar) != null){
                    $removeImagem = "DELETE FROM imagem where codImagem = {$codImagem}";
                    queryExec($removeImagem);
                    header("Location:index.php?removido=true");
            }

        }
    }
    
}
