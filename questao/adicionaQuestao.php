<?php
include("../config.php");
//-------------- Adiciona Imagem --------------
function adicionaImagem($db, $tituloImagem, $bitmapImagem){
    $sql = odbc_prepare($db, "INSERT INTO imagem (tituloImagem, bitmapImagem) output INSERTED.codImagem  VALUES (?, ?)");
    $query = odbc_execute($sql, array($tituloImagem, $bitmapImagem));
    $row = odbc_fetch_array($sql);
    return $row['codImagem'];
}
if(isset($_POST['textoQuestao'])){

    $tituloImagem = $_POST['tituloImagem'];
    if(isset($_FILES['imagem'])){
        if(substr($_FILES['imagem']['type'], 0, 5) == 'image' &&
            $_FILES['imagem']['error'] == 0 &&
            ($_FILES['imagem']['size'] > 0 && $_FILES['imagem']['size'] < 9000000)){
            $file = fopen($_FILES['imagem']['tmp_name'], 'rb');
            $bitmapImagem = fread($file, filesize($_FILES['imagem']['tmp_name']));
            fclose($file);
            $codImagem = adicionaImagem($db, $tituloImagem, $bitmapImagem);
        }
    }
    //-------------- Adiciona Questao --------------
    $enunciado = $_POST['textoQuestao'];
    $assunto = $_POST['codAssunto'];
    $dificuldade = $_POST['dificuldade'];
    $sql_Questao = odbc_prepare($db, "INSERT INTO questao (textoQuestao, codAssunto, codImagem, codTipoQuestao, codProfessor, ativo, dificuldade) OUTPUT INSERTED.codQuestao
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
    $result_Questao = odbc_execute($sql_Questao, array($enunciado, $assunto, $codImagem, 'A', '1', '1', $dificuldade));
    $row_Questao = odbc_fetch_array($sql_Questao);
    $codQuestao = $row_Questao['codQuestao'];
     echo $codQuestao;
    $correto = $_POST['correta'];
    for($i = 1;$i <= 4;$i++){
        $c = '0';
            $codAlternativa = $i;
        if($correto == $codAlternativa){
           $c = '1';
        }
            $textoAlternativa = $_POST[$i];
            $query = odbc_prepare($db, "INSERT INTO Alternativa (codQuestao, codAlternativa, textoAlternativa, correta)
                                                            VALUES (?, ?, ?, ?)");
        $resultado = odbc_execute($query, array($codQuestao, $codAlternativa, $textoAlternativa, $c));
    }
    header("Location: index.php?adicionado=true");
}else{
    header("Location: index.php");
}
?>
