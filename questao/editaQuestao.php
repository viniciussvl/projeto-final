<?php
include("../config.php");
ini_set('odbc.defaultlrl', '1M');

// BUSCA QUESTAO
if(isset($_GET['editar'])){
  $id = $_GET['editar'];
  $buscaQuestao = odbc_exec($db, "SELECT * FROM Questao WHERE codQuestao = $id");
  while($linha_questao = odbc_fetch_array($buscaQuestao)){
      $enunciado = $linha_questao['textoQuestao'];
      $assuntoQuestao = $linha_questao['codAssunto'];
      $dificuldade = $linha_questao['dificuldade'];
      $imagem_questao = $linha_questao['codImagem'];
      $ativo = $linha_questao['ativo'];
  }

  $buscaAssunto = odbc_exec($db, "SELECT * FROM Assunto");

  $buscaimagem = odbc_exec($db, "SELECT * FROM Imagem WHERE codImagem = '$imagem_questao'");
  while($linha_imagem = odbc_fetch_array($buscaimagem)){
      $imagem_tabela = $linha_imagem['codImagem'];
      $tituloImagem = $linha_imagem['tituloImagem'];
      $bitmapImagem = base64_encode($linha_imagem['bitmapImagem']);
  }
  if($imagem_questao == @$imagem_tabela){
      $imagem = "<img src='data:image/jpeg;base64,". @$bitmapImagem ."' width='100px' heigth='100px'>";
  }else if($imagem_questao == 'null'){
      $imagem = "<p>SEM IMAGEM</p>";
  }


  $sql = odbc_exec($db, "SELECT * FROM Alternativa WHERE codQuestao = $id");

  $alternativa = array();
  $buscaAlternativa = odbc_exec($db, "SELECT * FROM alternativa WHERE codQuestao = $id");
  while($row = odbc_fetch_array($buscaAlternativa)){
      array_push($alternativa, $row);
  }
}


//EDITA Questao
if(isset($_POST['textoQuestao'])){
  $textoQuestao = $_POST['textoQuestao'];
  $codAssunto = $_POST['codAssunto'];
  $dificuldade = $_POST['dificuldade'];
  $ativo = $_POST['status'];
  $codQuestao = $_POST['codQuestao'];
  $codImagem = $_POST['codImagem'];
  $tituloImagem = $_POST['tituloImagem'];
  if($ativo == "ativada"){
    $ativo = 1;
  }else{
    $ativo = 0;
  }

//UPDATE IMAGEM SE ENVIOU UMA NOVA IMAGEM
if(isset($_FILES['imagem'])){
  if(substr($_FILES['imagem']['type'], 0, 5) == 'image' &&
  $_FILES['imagem']['error'] == 0 &&
  ($_FILES['imagem']['size'] > 0 && $_FILES['imagem']['size'] < 9000000)){
    $file = fopen($_FILES['imagem']['tmp_name'], 'rb');
    $bitmapImagem = fread($file, filesize($_FILES['imagem']['tmp_name']));
    fclose($file);
    //executa a troca da imagem no banco
    $sql = odbc_prepare($db, "UPDATE imagem
                              SET  bitmapImagem = ?
                              WHERE codImagem = ?");
    $query = odbc_execute($sql, array($bitmapImagem,$codImagem));
    echo "IMAGEM OK";
  }
}

//UPDATE TITULO IMAGEM
$sql = odbc_prepare($db, "UPDATE imagem
                          SET tituloImagem = ?
                          WHERE codImagem = ? ");
$query = odbc_execute($sql, array($tituloImagem, $codImagem));

//UPDATE QUESTAO
$sql = odbc_prepare($db,"UPDATE Questao
                         SET textoQuestao = ?,
                         codAssunto = ?,
                         codImagem = ?,
                         ativo = ?,
                         dificuldade = ?
                         WHERE codQuestao = ?");
$query = odbc_execute($sql, array($textoQuestao, $codAssunto, $codImagem, $ativo, $dificuldade,$codQuestao ));

//UPDATE ALTERNATIVA
for($i = 1 ; $i <= 4 ; $i++){
    if($_POST['correta'] == $i){
      $correta = 1;
    }else{
      $correta = 0;
    }
    $textoAlternativa = $_POST[$i];
    $sql = odbc_prepare($db,"UPDATE alternativa
                             SET textoAlternativa = ?,
                                 correta = ?
                             WHERE codQuestao = ? AND codAlternativa = ?");

    $query = odbc_execute($sql, array($textoAlternativa, $correta, $codQuestao, $i));
  }
  header("location: index.php?editado=true");
}

include("../inc/header.php");
echo "<div class='container'>";
?>
<fieldset>
    <legend>Alterar dados da Quest&atilde;o</legend>
    <div class="col-sm-offset-3">
        <form method="POST" action="editaQuestao.php" name="formQuestao" class="form-horizontal" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>
                        <div class="form-group">
                            <label for="textoQuestao" class="col-sm-3 control-label">Enunciado</label>
                            <div class="col-sm-8">
                                <textarea name="textoQuestao" class="form-control" rows="3" cols="55" required><?= $enunciado ?></textarea>
                                <input type="hidden" name="codQuestao" value=<?= $_GET['editar']?> >
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
                                    while ($row = odbc_fetch_array($buscaAssunto)) {
                                        $codAssunto = $row['codAssunto'];
                                        $descricao = $row['descricao'];

                                        if($codAssunto == $assuntoQuestao){
                                            $selected = "selected=selected";
                                        }else{
                                            $selected = "";
                                        }

                                        echo "<option value='$codAssunto' $selected>$descricao</option>";
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
                                    <option name="dificuldade">Selecione uma dificuldade</option>
                                    <option value="F" <?php if($dificuldade == "F") echo "selected"; ?>>F&aacute;cil</option>
                                    <option value="M" <?php if($dificuldade == "M") echo "selected"; ?>>M&eacute;dio</option>
                                    <option value="D" <?php if($dificuldade == "D") echo "selected"; ?>>Dif&iacute;cil</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ativada" class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-8">
                                <input type="radio" name="status" value="ativada" <?= $ativo == 1 ? "checked" : ""?> > Ativar
                                <input type="radio" name="status" value="desativada" <?= $ativo == 0   ? "checked" : ""?> > Desativar
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <!--passar valor imagem para edição-->
                        <div class="form-group">
                            <label for="file" class="col-sm-3 control-label">Imagem</label>
                            <div class="col-sm-8">
                                <input type="file" name="imagem">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?=$imagem?>
                          <input type="hidden" name="codImagem" value="<?= $imagem_tabela ?>">
                          <input type="hidden" name="bitmapImagem" value="<?= $imagem ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <label for="tituloImagem" class="col-sm-3 control-label">T&iacute;tulo da Imagem</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" name="tituloImagem" value="<?= @$tituloImagem?>">
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
                                  <input class="form-control" type="text" name="1" value="<?= isset($alternativa[0]) ? $alternativa[0]['textoAlternativa'] : "" ?>">
                              </div>
                              <div class="col-sm-2 radio">
                                  <label>
                                      <input type="radio" name="correta"  value="1" <?= isset($alternativa[0]) && $alternativa[0]["correta"] == '1' ? 'checked' : " " ?>>
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
                                  <input class="form-control" type="text" name="2" value="<?= isset($alternativa[1]) ? $alternativa[1]['textoAlternativa'] : "" ?>">
                              </div>
                              <div class="col-sm-2 radio">
                                  <label>
                                      <input type="radio" name="correta" value="2" <?= isset($alternativa[1]) && $alternativa[1]["correta"] == '1' ? 'checked' : " "?> >
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
                                  <input class="form-control" type="text" name="3" value="<?= isset($alternativa[2]) ? $alternativa[2]['textoAlternativa'] : "" ?>">
                              </div>
                              <div class="col-sm-2 radio">
                                  <label>
                                      <input type="radio" name="correta" value="3" <?= isset($alternativa[2]) && $alternativa[2]["correta"] == '1' ? 'checked' : " "?> >
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
                                  <input class="form-control" type="text" name="4" value="<?= isset($alternativa[3]) ? $alternativa[3]['textoAlternativa'] : "" ?>">
                              </div>
                              <div class="col-sm-2 radio">
                                  <label>
                                      <input type="radio" name="correta" value="4" <?= isset($alternativa[3]) && $alternativa[3]["correta"] == '1' ? 'checked' : " " ?> >
                                      Correta
                                  </label>
                              </div>
                          </div>
                      </div>
                      <input type="submit" class="btn btn-primary" value="Editar">
                  </td>
              </tr>
          </table>
      </form>
  </div>
</fieldset>
