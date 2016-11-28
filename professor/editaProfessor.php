<?php
include("../config.php");
error_reporting(0);
session_start();
if($_SESSION['tipoProfessor'] != "A"){
    header("Location: index.php");
} 

$id = $_GET['editar'];

$sql = "SELECT * FROM Professor WHERE codProfessor = '$id'";

$buscaProfessor = odbc_exec($db, $sql);

while($professor = odbc_fetch_array($buscaProfessor)){
    $id = $professor['codProfessor'];
    $nome = $professor['nome'];
    $email = $professor['email'];
    $senhaAtual = $professor['senha'];
    $idDoSenac = $professor['idSenac'];
    $tipoProfessor = $professor['tipo'];
}




if(isset($_POST['nomeProfessor'])){
    $idProfessor = $_POST['codProfessor'];
    $nomeProfessor = $_POST['nomeProfessor'];
    $emailProfessor = $_POST['emailProfessor'];
    $senhaProfessor = $_POST['senhaProfessor'];
    $idSenac = $_POST['idSenac'];
    $tipoLogin = $_POST['tipoLogin'];

    //Usar Essa Query caso o professor mude a senha.
    $editaProfessor = "UPDATE Professor SET 
                                nome = '$nomeProfessor', 
                                email = '$emailProfessor', 
                                senha = HASHBYTES('SHA1', '{$senhaProfessor}'), 
                                idSenac = $idSenac, 
                                tipo = '$tipoLogin'
                       WHERE codProfessor = $idProfessor";

    //Usar Essa Query caso o professor mantenha a mesma senha.
    $editaSemSenha = "UPDATE Professor SET 
                            nome = '$nomeProfessor', 
                            email = '$emailProfessor',
                            idSenac = $idSenac, 
                            tipo = '$tipoLogin'
                   WHERE codProfessor = $idProfessor";
    
    //verifica se houve troca de senha
    if($senhaAtual != $senhaProfessor){
      if(odbc_exec($db, $editaProfessor)){
        header("Location: index.php?editado=true");
      }else {
        echo "erro";
      }
    }else{
      if(odbc_exec($db, $editaSemSenha )){
        header("Location: index.php?editado=true");
      }else {
        echo "erro";
      }
    } 
}

include("../inc/header.php");
echo "<div class='container'>";
?>

<fieldset class="col-md-offset-3 col-md-5">    
    <legend>Alterar Dados do Professor</legend>
    <form method="POST">
        <input type="hidden" name="codProfessor" value="<?= $id; ?>">
        <div class="form-group">
            <label for="nomeProfessor">Nome</label>
            <input type="text" class="form-control" name="nomeProfessor" value="<?= $nome; ?>">
        </div>
        <div class="form-group">
            <label for="emailProfessor">Email</label>
            <input type="email" class="form-control" name="emailProfessor" value="<?= $email; ?>">
        </div>
        <div class="form-group">
            <label for="senhaProfessor">Senha</label>
            <input type="password" class="form-control" name="senhaProfessor" value="<?= $senhaAtual; ?>">
        </div>
        <div class="form-group">
            <label for="idProfessor">Id Senac</label>
            <input type="text" class="form-control" name="idSenac" value="<?= $idDoSenac ?>">
        </div>
        <div class="radio">
            <label class="radio-inline">
                <input type="radio" name="tipoLogin" value="P" <?php if($tipoProfessor == 'P') echo "checked"; ?>> Professor
            </label>
            <label class="radio-inline">
                <input type="radio" name="tipoLogin" value="A" <?php if($tipoProfessor == 'A') echo "checked"; ?>> Administrador
            </label>
        </div>
        <button type="submit" class="btn btn-default">Cadastrar</button>
    </form>
</fieldset>