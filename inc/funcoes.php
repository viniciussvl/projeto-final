<?php
include("../config.php");

// --------------- ÁREA --------------- //
function listarAreas(){
	global $db;
    $sql = "SELECT codArea, descricao FROM Area ORDER BY codArea DESC";
    $query = odbc_exec($db, $sql);
    return $query;
}

function removeArea($id){
	global $db;
    $sql = "DELETE FROM Area WHERE codArea = {$id}";
    $query = odbc_exec($db, $sql);
    return $query;
}

function novaArea($descricao){
	global $db;
	$sql = "INSERT INTO Area (descricao) VALUES ('$descricao')";
	$query = odbc_exec($db, $sql);
	return $query;
}

function editaArea($id, $descricao){
	global $db;
	$sql = "UPDATE Area SET descricao = '$descricao' WHERE codArea = {$id}";
	$query = odbc_exec($db, $sql);
	return $query;
}
function buscaArea($id){
	global $db;
	$sql = odbc_exec($db, "SELECT * FROM Area WHERE codArea = $id");
  	$query = odbc_fetch_array($sql);
  	return $query;
}

function verificarIntegridadeArea($id){
	global $db;
    $sql = "SELECT codArea FROM Assunto WHERE codArea = {$id}";
    $query = odbc_exec($db, $sql);
    return $query;
}

// --------------- ASSUNTO --------------- //
function listarAssuntos(){
	global $db;

    $sql = "SELECT ass.descricao as Assunto, are.descricao as Area, codAssunto
    		FROM Assunto as ass INNER JOIN Area as are
    		ON ass.codArea = are.codArea
                ORDER BY codAssunto DESC";

    $query = odbc_exec($db, $sql);
    return $query;
}

function removeAssunto($id){
	global $db;
    $sql = "DELETE FROM Assunto WHERE codAssunto = {$id}";
    $query = odbc_exec($db, $sql);
    return $query;
}

function novoAssunto($descricao, $area){		
	global $db;
	$sql = "INSERT INTO Assunto (descricao, codArea) VALUES ('$descricao', '$area')";
	$query = odbc_exec($db, $sql);
	return $query;
}

function editaAssunto($id, $descricao, $codArea){
	global $db;
	$sql = "UPDATE Assunto SET descricao = '$descricao', codArea = '$codArea' WHERE codAssunto = '$id'";
	$query = odbc_exec($db, $sql);
	return $query;
}

function verificarIntegridadeAssunto($id){
	global $db;
    $sql = "SELECT codAssunto FROM Assunto WHERE codAssunto = {$id}";
    $query = odbc_exec($db, $sql);
    return $query;
}


// --------------- PROFESSOR --------------- //
function listarProfessor(){
	global $db;

    $sql = "SELECT * FROM professor";
    $query = odbc_exec($db, $sql);
    return $query;
}

function removeProfessor($id){
	global $db;
    $sql = "DELETE FROM Professor WHERE codProfessor = {$id}";
    $query = odbc_exec($db, $sql);
    return $query;
}

function novoProfessor($nome, $email, $senha, $idSenac, $tipo){
	global $db;
	$sql = "INSERT INTO Professor
						(nome,
						email,
						senha,
						idSenac,
						tipo)
					VALUES(
						'$nome',
						'$email',
						HASHBYTES('SHA1', '{$senha}'),
						'$idSenac',
						'$tipo')";
	$query = odbc_exec($db, $sql);
	return $query;
}

function editaProfessor($codProfessor,$nome,$email,$idSenac,$tipo){
	global $db;
	$sql = "UPDATE Professor
					SET nome = '$nome',
							email = '$email',
							idSenac = '$idSenac',
							tipo = '$tipo'
					WHERE codProfessor = '$codProfessor'";
	$query = odbc_exec($db, $sql);
	return $query;
}

function editaSenhaProfessor($codProfessor,$senha){
	global $db;
	$sql = "UPDATE Professor
					SET senha = HASHBYTES('SHA1', '{$senha}'),
					WHERE codProfessor = '$codProfessor'";
	$query = odbc_exec($db, $sql);
	return $query;
}

function buscaProfessor($id){
  global $db;
  $sql = odbc_exec($db, "SELECT * FROM professor WHERE codProfessor = $id");
  $query = odbc_fetch_array($sql);
  return $query;
}

function verificarIntegridadeProfessor($id){
	  global $db;
    $sql = "SELECT codProfessor FROM questao WHERE codProfessor = '$id'";
    $query = odbc_exec($db, $sql);
    return $query;
}

// --------------- QUESTÃO --------------- //
function adicionaImagem($db, $tituloImagem, $bitmapImagem){

    $query = odbc_prepare($db, "INSERT INTO imagem (tituloImagem, bitmapImagem) output INSERTED.codImagem  VALUES (?, ?)");
    $resultado = odbc_execute($query, array($tituloImagem, $bitmapImagem));
    $result = odbc_fetch_array($query);
    return $result['codImagem'];

}

function adicionaQuestao($db, $enunciado, $assunto, $codImagem, $dificuldade){

    $query = odbc_prepare($db, "INSERT INTO questao (textoQuestao, codAssunto, codImagem, codTipoQuestao, codProfessor, ativo, dificuldade) OUTPUT INSERTED.codQuestao
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
    $resultado = odbc_execute($query, array($enunciado, $assunto, $codImagem, 'A', '1', '1', $dificuldade));
    $result = odbc_fetch_array($query);
    return $result['codQuestao'];
}

function buscaQuestao($id){
    global $db;
  	$sql = odbc_exec($db, "SELECT * FROM Questao WHERE codQuestao = $id");
    $query = odbc_fetch_array($sql);
    return $query;
}

function buscaAlternativa($id){
    global $db;
  	$sql = odbc_exec($db, "SELECT * FROM Alternativa WHERE codQuestao = $id");

    $query = array();
    while($row = odbc_fetch_array($sql)){
      array_push($query,$row);
    }
    return $query;
}

function buscaImagem($id){
    global $db;
  	$sql = odbc_exec($db, "SELECT *  
                           FROM questao
                           JOIN imagem
                           ON questao.codImagem = imagem.codImagem
                           WHERE questao.codQuestao = $id");
    $query = odbc_fetch_array($sql);
    return $query;
}
?>
