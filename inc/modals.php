

<!---------------- MODAL &aacute;REA ---------------->

<?php
include("../config.php");
if (isset($_POST['descricaoArea'])) {
    $descricao = $_POST['descricaoArea'];
    $query = odbc_exec($db, "INSERT INTO Area (descricao) VALUES ('$descricao')");
}
?>


<div class="modal fade" id="modalArea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Nova &aacute;rea</h4>
            </div>
            <div class="modal-body">
                <form id="novaArea" name="novaArea" class="form-horizontal" method="POST">
                    <div class="form-group">
                        <label for="descricao" class="col-sm-2 control-label">Descri&ccedil;&atilde;o</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="descricaoArea" name="descricaoArea" required>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <input type="submit" class="btn btn-primary" value="Adicionar &aacute;rea">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!---------------- MODAL ASSUNTO ---------------->
<?php
$sqlArea = odbc_exec($db, "SELECT * FROM Area");
if (isset($_POST['descricao']) && isset($_POST['area'])) {
    $area = $_POST['area'];
    $descricao = $_POST['descricao'];
    $sql = odbc_exec($db, "INSERT INTO Assunto (descricao, codArea) VALUES ('$descricao', '$area')");
}
?>



<div class="modal fade" id="modalAssunto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Novo assunto</h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="novoAssunto" name="novoAssunto" class="form-horizontal">
                    <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 col-sm-offset-2 control-label">&Aacute;rea</label>
                            <div class="col-sm-6">
                                <select name="area" class="form-control" required>
                                    <?php
                                    while ($row = odbc_fetch_array($sqlArea)) {
                                        $codArea = $row['codArea'];
                                        $descricao = $row['descricao'];
                                        echo "<option value='$codArea'>$descricao</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 col-sm-offset-2 control-label">Descri&ccedil;&atilde;o</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="descricao" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <input type="submit" class="btn btn-primary" value="Adicionar assunto">
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>



<!---------------- MODAL PROFESSOR ---------------->

<?php
if (isset($_POST['nomeProfessor'])) {
    $nome = $_POST['nomeProfessor'];
    $email = $_POST['emailProfessor'];
    $senha = $_POST['senhaProfessor'];
    $idSenac = $_POST['idSenac'];
    $tipo = $_POST['tipoLogin'];
    $query = odbc_exec($db, "INSERT INTO professor (nome, email, senha, idSenac, tipo)
                                VALUES ('$nome', '$email', HASHBYTES('SHA1', '{$senha}'), '$idSenac', '$tipo')");
}
?>

<div class="modal fade" id="modalProfessor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Novo professor</h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="novoProfessor" name="novoProfessor">
                    <div class="form-group">
                        <label for="nomeProfessor">Nome</label>
                        <input type="text" class="form-control" name="nomeProfessor" placeholder="Nome">
                    </div>
                    <div class="form-group">
                        <label for="emailProfessor">Email</label>
                        <input type="email" class="form-control" name="emailProfessor" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="senhaProfessor">Senha</label>
                        <input type="password" class="form-control" name="senhaProfessor" placeholder="Senha">
                    </div>
                    <div class="form-group">
                        <label for="idProfessor">Id Senac</label>
                        <input type="text" class="form-control" name="idSenac" maxlength="6" placeholder="ID" required>
                    </div>
                    <div class="radio">
                        <label class="radio-inline">
                            <input type="radio" name="tipoLogin" value="P"> Professor
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="tipoLogin" value="A"> Administrador
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <input type="submit" class="btn btn-primary" value="Adicionar professor">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!---------------- MODAL quest&atilde;o ---------------->
<?php
$listarAssuntos = odbc_exec($db, "SELECT * FROM Assunto ORDER BY codAssunto DESC");
?>


<div class="modal fade" id="modalQuestao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Nova quest&atilde;o</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="adicionaQuestao.php" id="formQuestao" name="formQuestao" class="form-horizontal" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label for="textoQuestao" class="col-sm-3 control-label">Enunciado</label>
                                    <div class="col-sm-8">
                                        <textarea name="textoQuestao" class="form-control" rows="3" cols="55" required></textarea>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label for="codAssunto" class="col-sm-3 control-label">Assunto</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="codAssunto" required>
                                            <option value="">Selecione um assunto</option>
                                            <?php
                                            while ($row = odbc_fetch_array($listarAssuntos)) {
                                                $codAssunto = $row['codAssunto'];
                                                $descricao = $row['descricao'];

                                                echo "<option value='$codAssunto'>$descricao</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label for="dificuldade" class="col-sm-3 control-label">Dificuldade</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="dificuldade" required>
                                            <option value="" name="dificuldade">Selecione uma dificuldade</option>
                                            <option value="F">F&aacute;cil</option>
                                            <option value="M">M&eacute;dio</option>
                                            <option value="D">Dif&iacute;cil</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!--passar valor imagem para edi&ccedil;ão-->
                                <div class="form-group">
                                    <label for="file" class="col-sm-3 control-label">Imagem</label>
                                    <div class="col-sm-8">
                                        <input type="file" name="codImagem" value="">
                                        <div>
                                        </div>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label for="tituloImagem" class="col-sm-3 control-label">T&iacute;tulo da Imagem</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text" name="tituloImagem">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="">
                                                        <label class="col-sm-3 control-label">Alternativa A</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text" name="1" required>
                                                        </div>
                                                        <div class="col-sm-2 radio">
                                                            <label>
                                                                <input type="radio" name="correta" value="1" required>
                                                                Correta
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div>
                                                        <label class="col-sm-3 control-label">Alternativa B</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text" name="2" required>
                                                        </div>
                                                        <div class="col-sm-2 radio">
                                                            <label>
                                                                <input type="radio" name="correta" value="2" required>
                                                                Correta
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div>
                                                        <label class="col-sm-3 control-label">Alternativa C</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text" name="3" required>
                                                        </div>
                                                        <div class="col-sm-2 radio">
                                                            <label>
                                                                <input type="radio" name="correta" value="3" required>
                                                                Correta
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div>
                                                        <label class="col-sm-3 control-label">Alternativa D</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" type="text" name="4" required>
                                                        </div>
                                                        <div class="col-sm-2 radio">
                                                            <label>
                                                                <input type="radio" name="correta" value="4" required>
                                                                Correta
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        </table>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                            <input type="submit" class="btn btn-primary" value="Adicionar quest&atilde;o">
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                                </div>