<?php
include("../config.php");
ini_set('odbc.defaultlrl', '1M');
// Paginação
if (isset($_GET['n'])) {
    $idAssunto = $_GET['n'];
        $query = odbc_exec($db, "SELECT codQuestao, textoQuestao as Enunciado, A.descricao as Assunto, I.bitmapImagem as Imagem, P.nome AS Professor, ativo, dificuldade
                                FROM Questao AS Q INNER JOIN Assunto as A
                                ON Q.codAssunto = A.codAssunto
                                INNER JOIN Professor AS P
                                ON Q.codProfessor = P.codProfessor
                                INNER JOIN Imagem AS I
                                ON Q.codImagem = I.codImagem
                                    WHERE a.codAssunto = '$idAssunto'");
    $pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
    $cont = odbc_num_rows($query);
    $registros = 10;
    $numPaginas = ceil($cont / $registros);
    $inicio = ($registros * $pagina) - $registros;
    if ($pagina > $numPaginas || $pagina <= 0) {
        header("Location: index.php?pagina=1&erro=assunto");
    }
} else {
    if (isset($_GET['nome'])) {
        $nomeProf = $_GET['nome'];
        $query = odbc_exec($db, "SELECT codQuestao, textoQuestao as Enunciado, A.descricao as Assunto, I.bitmapImagem as Imagem, P.nome AS Professor, ativo, dificuldade
                                FROM Questao AS Q INNER JOIN Assunto as A
                                ON Q.codAssunto = A.codAssunto
                                INNER JOIN Professor AS P
                                ON Q.codProfessor = P.codProfessor
                                INNER JOIN Imagem AS I
                                ON Q.codImagem = I.codImagem
                                        WHERE p.nome = '$nomeProf'");

        $pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
        $cont = odbc_num_rows($query);
        $registros = 10;
        $numPaginas = ceil($cont / $registros);
        $inicio = ($registros * $pagina) - $registros;
        if ($pagina > $numPaginas || $pagina <= 0) {
            $_SESSION['nomeProfessor'] = $nomeProf;
            header("Location: index.php?pagina=1&filtro=professor&erro=prof");
        }
    } else {

        $queryPadrao = odbc_exec($db, "SELECT * FROM Questao");
        $pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
        $cont = odbc_num_rows($queryPadrao);
        $registros = 10;
        $numPaginas = ceil($cont / $registros);
        $inicio = ($registros * $pagina) - $registros;
        if ($pagina > $numPaginas || $pagina <= 0) {
            header("Location: index.php?pagina=1");
        }
    }
}


// FILTRO
$dif = "dificuldadeA";
$prof = "professorA";
$tip = "tipoA";
$ass = "assuntoA";
$status = "statusA";
$enun = "enunciadoA";
$ordenar = "codQuestao DESC";

if (isset($_GET['filtro'])) {
    $filtro = $_GET['filtro'];
    switch ($filtro) {
        case ('enunciadoA'):
            $ordenar = "textoQuestao";
            break;
        case ('assuntoA'):
            $ordenar = "a.descricao";
            break;
        case ('assuntoD'):
            $ordenar = "a.descricao DESC";
            break;
        case ('enunciadoD'):
            $ordenar = "textoQuestao DESC";
            break;
        case ('professorA'):
            $ordenar = "p.codProfessor";
            break;
        case ('professorD'):
            $ordenar = "p.codProfessor DESC";
            break;
        case ('tipoA'):
            $ordenar = "codTipoQuestao";
            break;
        case ('tipoB'):
            $ordenar = "codTipoQuestao DESC";
            break;
        case('statusA'):
            $ordenar = "ativo";
            break;
        case('statusD'):
            $ordenar = "ativo DESC";
            break;
        case('dificuldadeA'):
            $ordenar = "dificuldade";
            break;
        case('dificuldadeD'):
            $ordenar = "dificuldade DESC";
            break;
    }

    // Filtrar por crescente e decrescente
    if ($filtro == "enunciadoA") {
        $enun = "enunciadoD";
    } else {
        $enun = "enunciadoA";
    }

    if ($filtro == "assuntoA") {
        $ass = "assuntoD";
    } else {
        $ass = "assuntoA";
    }

    if ($filtro == "dificuldadeA") {
        $dif = "dificuldadeD";
    } else {
        $dif = "dificuldadeA";
    }
    if ($filtro == "professorA") {
        $prof = "professorD";
    } else {
        $prof = "professorA";
    }
    if ($filtro == "tipoA") {
        $tip = "tipoD";
    } else {
        $tipo = "tipoA";
    }
    if ($filtro == "statusA") {
        $status = "statusD";
    } else {
        $status = "statusA";
    }
}

if (isset($_GET['n'])) {
    $idAssunto = $_GET['n'];
        $query = odbc_exec($db, "SELECT q.codQuestao, textoQuestao as Enunciado, A.descricao as Assunto, P.nome AS Professor, ativo, dificuldade
                                FROM Questao AS Q INNER JOIN Assunto as A
                                ON Q.codAssunto = A.codAssunto
                                INNER JOIN Professor AS P
                                ON Q.codProfessor = P.codProfessor
                                    WHERE a.codAssunto = '$idAssunto'
                                    ORDER BY $ordenar OFFSET $inicio ROWS FETCH NEXT $registros ROWS ONLY");
} else {
    if (isset($_GET['nome'])) {
        $nomeProf = $_GET['nome'];
        $query = odbc_exec($db, "SELECT q.codQuestao, textoQuestao as Enunciado, A.descricao as Assunto, P.nome AS Professor, ativo, dificuldade
                                FROM Questao AS Q INNER JOIN Assunto as A
                                ON Q.codAssunto = A.codAssunto
                                INNER JOIN Professor AS P
                                ON Q.codProfessor = P.codProfessor
                                    WHERE p.nome = '$nomeProf'
                                    ORDER BY $ordenar OFFSET $inicio ROWS FETCH NEXT $registros ROWS ONLY");
    } else {
        $query = odbc_exec($db, "SELECT codQuestao, textoQuestao as Enunciado, A.descricao as Assunto, P.nome AS Professor, ativo, dificuldade
                                FROM Questao AS Q 
                                INNER JOIN Assunto as A
                                    ON Q.codAssunto = A.codAssunto
                                INNER JOIN Professor AS P
                                    ON Q.codProfessor = P.codProfessor
                                
                                    ORDER BY $ordenar OFFSET $inicio ROWS FETCH NEXT $registros ROWS ONLY");
    }
}
include("../inc/header.php");
/* ------------ Fim do filtro ------------ > */

echo "<div class='container'>";

if (isset($_GET['adicionado']) && $_GET['adicionado'] == 'true') {
    echo "<div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  Quest&atilde;o adicionada com sucesso!
</div>";
}

if (isset($_GET['removido']) && $_GET['removido'] == 'true') {
    echo "<div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  Quest&atilde;o deletada com sucesso!
</div>";
}
if (isset($_GET['desativada']) && $_GET['desativada'] == 'true') {
    echo "<div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  Essa quest&atilde;o não pode ser removida e foi desativada
</div>";
}
if (isset($_GET['editado']) && $_GET['editado'] == 'true') {
    echo "<div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  Quest&atilde;o editada com sucesso!
</div>";
}

if (isset($_GET['erro']) && $_GET['erro'] == 'assunto') {
    echo "<div class='alert alert-warning alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  Não existe quest&atilde;o relacionada com esse assunto!
</div>";
}


if (isset($_SESSION['nomeProfessor'])) {
    $nomeProfessor = $_SESSION['nomeProfessor'];
    if (isset($_GET['erro']) && $_GET['erro'] == 'prof') {
        echo "<div class='alert alert-warning alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  Não existe quest&atilde;o relacionada com o professor <strong>$nomeProfessor</strong>
</div>";
    }
}
?>


<div clss="container">
    <a data-toggle="modal" data-target="#modalQuestao" class="right btn btn-success"><i class="glyphicon glyphicon-plus"></i>Nova questao</a>
    <div class="clearfix"></div>
    <fieldset>
        <legend>Quest&otilde;es</legend>
        <div class="barra-navegacao col-md-8">
            <form class="form-inline left" method="GET" >
                <input type="hidden" name="pagina" value="<?php echo $pagina; ?>">
                <div class="form-group">
                    <label for="listar">Listar por</label>
                    <select id="filtro" name="filtro" class="form-control" onchange="this.form.submit()">
                        <option value="">Selecione</option>
                        <option value="assunto"
                        <?php
                        if (isset($filtro) && $filtro == "assunto") {
                            echo "selected";
                        }
                        ?>> Assunto
                        </option>

                        <option value="dificuldadeA"
                        <?php
                        if (isset($filtro) && $filtro == "dificuldadeA" || isset($filtro) && $filtro == "dificuldadeD") {
                            echo "selected";
                        }
                        ?>> Dificuldade
                        </option>

                        <option value="professor"
                        <?php
                        if (isset($filtro) && $filtro == "professor" || isset($filtro) && $filtro == "professorA" || isset($filtro) && $filtro == "professorD") {
                            echo "selected";
                        }
                        ?>> Professor
                        </option>

                        <option value="statusA" <?php
                        if (isset($filtro) && $filtro == "statusoA" || isset($filtro) && $filtro == "statusD") {
                            echo "selected";
                        }
                        ?>>Status
                        </option>
                        <option value="tipoA" <?php if (isset($filtro) && $filtro == "tipoA" || isset($filtro) && $filtro == "tipoD") echo "selected"; ?>>Tipo
                        </option>
                    </select>
                </div>
            </form>
            <?php
            if (isset($_GET['filtro']) && $_GET['filtro'] == "assunto") {
                $sql = odbc_exec($db, "SELECT * FROM Assunto");
                ?>
                <form class="form-inline left" method="GET" >
                    <input type="hidden" name="pagina" value="1">
                    <input type="hidden" name="filtro" value="assunto">
                    <div class="form-group">
                        <select id="filtro" name="n" class="form-control" onchange="this.form.submit()">
                            <option value="">Selecione o assunto</option>
                            <?php
                            while ($row = odbc_fetch_array($sql)):
                                $idAssunto = $row['codAssunto'];
                                $nomeAssunto = $row['descricao'];
                                ?>
                                <option value="<?= $idAssunto; ?>" <?php if (isset($_GET['n']) && $_GET['n'] == $idAssunto) echo "selected"; ?>>
                                    <?= $nomeAssunto; ?>
                                </option>

                            <?php endwhile; ?>
                        </select>
                    </div>
                </form>
                <?php
            }
            if (isset($_GET['filtro']) && $_GET['filtro'] == "professor") {
                $sql = odbc_exec($db, "SELECT * FROM Professor");
                ?>
                <form class="form-inline left" method="GET" >
                    <input type="hidden" name="pagina" value="1">
                    <input type="hidden" name="filtro" value="professor">
                    <div class="form-group">
                        <select id="filtro" name="nome" class="form-control" onchange="this.form.submit()">
                            <option value="">Selecione o professor</option>
                            <?php
                            while ($row = odbc_fetch_array($sql)):
                                $codProfessor = $row['codProfessor'];
                                $nomeProf = $row['nome'];
                                ?>
                                <option value="<?= $nomeProf; ?>" <?php if (isset($_GET['nome']) && $_GET['nome'] == $nomeProf) echo "selected"; ?>>
                                    <?= $nomeProf; ?>
                                </option>

                            <?php endwhile; ?>
                        </select>
                    </div>
                </form>
            <?php }
            ?>

        </div>
        <table class="table table-bordered table-striped">
            <th>
                <a href="index.php?pagina=<?= $pagina; ?>&filtro=<?= $enun; ?>">Enunciado
                    <?php
                    if ($enun == "enunciadoA") {
                        echo "<i class='glyphicon glyphicon-triangle-bottom'></i>";
                    } else {
                        echo "<i style='color:#84c754;' class='glyphicon glyphicon-triangle-top'></i>";
                    }
                    ?>
                </a>
            </th>
            <th><a href="index.php?pagina=<?= $pagina; ?>&filtro=<?= $ass; ?>">Assunto
                    <?php
                    if ($ass == "assuntoA") {
                        echo "<i class='glyphicon glyphicon-triangle-bottom'></i>";
                    } else {
                        echo "<i style='color:#84c754;' class='glyphicon glyphicon-triangle-top'></i>";
                    }
                    ?>
                </a>
            </th>
            

            <th>
                <a href="index.php?pagina=<?= $pagina; ?>&filtro=<?= $prof; ?>">Professor
                    <?php
                    if ($prof == "professorA") {
                        echo "<i class='glyphicon glyphicon-triangle-bottom'></i>";
                    } else {
                        echo "<i style='color:#84c754;' class='glyphicon glyphicon-triangle-top'></i>";
                    }
                    ?>
                </a>

            </th>
            <th>
                <a href="index.php?pagina=<?= $pagina; ?>&filtro=<?= $status; ?>">Status
                    <?php
                    if ($status == "statusA") {
                        echo "<i class='glyphicon glyphicon-triangle-bottom'></i>";
                    } else {
                        echo "<i style='color:#84c754;' class='glyphicon glyphicon-triangle-top'></i>";
                    }
                    ?>
                </a>
            </th>
            <th>
                <a href="index.php?pagina=<?= $pagina; ?>&filtro=<?= $dif; ?>">Dificuldade
                    <?php
                    if ($dif == "dificuldadeA") {
                        echo "<i class='glyphicon glyphicon-triangle-bottom'></i>";
                    } else {
                        echo "<i style='color:#84c754;' class='glyphicon glyphicon-triangle-top'></i>";
                    }
                    ?>
                </a>
            </th>
            <th>Op&ccedil;&otilde;es</th>

            <?php
            while ($linha = odbc_fetch_array($query)) {
                $codQuestao = $linha['codQuestao'];
                $enunciado = $linha['Enunciado'];
                $assunto = $linha['Assunto'];
                $professor = $linha['Professor'];
                $ativo = $linha['ativo'];
                $dificuldade = $linha['dificuldade'];

                ($ativo == 1) ? $ativo = "Ativada" : $ativo = "Desativada";


                if ($dificuldade == "F") {
                    $dificuldade = "F&aacute;cil";
                } else if ($dificuldade == "M") {
                    $dificuldade = "M&eacute;dia";
                } else {
                    $dificuldade = "Dif&iacute;cil";
                }

               

                echo "<tr>
                        <td>$enunciado</td>
                        <td>$assunto</td>
                        <td>$professor</td>
                        <td>$ativo</td>
                        <td>$dificuldade</td>
                        <td>
                            <a href='deletarQuestao.php?remover=$codQuestao' onclick='return confirm('Deseja realmente excluir a Quest&atilde;o selecionada?')'><i class='glyphicon glyphicon-remove'></i></a>
                            <a href='editaQuestao.php?editar=$codQuestao'><i class='glyphicon glyphicon-pencil'></i></a>
                        </td>
                     </tr>";
            }
            ?>
        </table>
    </fieldset>
    <?php
    include("../inc/paginacao.php");
    ?>



</div>
<?php include("../inc/footer.php"); ?>
