<?php
include("../config.php");

$query = odbc_exec($db, 'SELECT count(*) AS qtd FROM Professor');
$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
$cont = odbc_fetch_array($query);
$registros = 10;
$numPaginas = ceil($cont['qtd'] / $registros);
$inicio = ($registros * $pagina) - $registros;
if ($pagina > $numPaginas || $pagina <= 0) {
    header("Location: index.php?pagina=1");
}

// FILTRO
$nome = "nomeA";
$email = "emailA";
$ordernar = "codProfessor DESC";

if (isset($_GET['filtro'])) {
    $filtro = $_GET['filtro'];
    switch ($filtro) {
        case ('nomeA'):
            $ordernar = "nome";
            break;
        case ('nomeD'):
            $ordernar = "nome DESC";
            break;
        case ('emailA'):
            $ordernar = "email";
            break;
        case ('emailD'):
            $ordernar = "email DESC";
            break;
    }
    // Filtrar por crescente e decrescente
    if ($filtro == "nomeA") {
        $nome = "nomeD";
    } else {
        $nome = "nomeA";
    }
    if ($filtro == "emailA") {
        $e = "emailD";
    } else {
        $e = "emailA";
    }
}


include("../inc/header.php");

echo "<div class='container'>";
if (isset($_GET['removido']) && $_GET['removido'] == 'true') {

    echo "<div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  Professor removido com sucesso!
</div>";
} else if (isset($_GET['relacionado']) && $_GET['relacionado'] == 'true') {

    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  <strong>ERRO!</strong> A uma quest&atilde;o relacionada com esse professor!
</div>";
}

if (isset($_GET['editado']) && $_GET['editado'] == 'true') {
    echo "<div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  Professor alterado com sucesso!
</div>";
}

if (isset($_GET['adicionado']) && $_GET['adicionado'] == 'true') {
    echo "<div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  Professor adicionado com sucesso!
</div>";
}

$query = odbc_exec($db, "SELECT nome, codProfessor, email, tipo FROM Professor ORDER BY $ordernar OFFSET $inicio ROWS FETCH NEXT $registros ROWS ONLY");
?>
<a data-toggle="modal" data-target="#modalProfessor" class="right btn btn-success"><i class="glyphicon glyphicon-plus"></i>Novo professor</a>
<div class="clearfix"></div>
<fieldset>
    <legend>Professores</legend>
    <div class="barra-navegacao col-md-8">
        <form class="form-inline left" method="GET" > 
            <input type="hidden" name="pagina" value="<?php echo $pagina; ?>">
            <div class="form-group">
                <label for="listar">Listar por</label>
                <select id="filtro" name="filtro" class="form-control" onchange="this.value !== 'nAtualiza' && this.form.submit()">
                    <option value="">Selecione</option>
                    <option value="nomeA" 
<?php
if (isset($filtro) && $filtro == "nomeA" || isset($filtro) && $filtro == "nomeD") {
    echo "selected";
}
?>> Nome
                    </option>

                </select>
            </div>
        </form> 

    </div>
    <table class="tabela table table-bordered table-striped">
        <tr>
            <th>
                <a href="index.php?pagina=<?= $pagina; ?>&filtro=<?= $nome; ?>">Professor
<?php
if ($nome == "nomeA") {
    echo "<i class='glyphicon glyphicon-triangle-bottom'></i>";
} else {
    echo "<i style='color:#84c754;' class='glyphicon glyphicon-triangle-top'></i>";
}
?>
                </a>

            </th>
            <th>Email</th>
            <th>Tipo</th>
<?php
if ($tipoProf == "A") {
    ?>
                <th>A&ccedil;&otilde;es</th>

<?php } ?>
        </tr>
            <?php
            while ($row = odbc_fetch_array($query)) {
                $id = $row['codProfessor'];
                $Professor = $row['nome'];
                $email = $row['email'];
                $tipo = $row['tipo'];
                ?>
            <tr>
                <td><?= $Professor; ?></td>
                <td><?= $email; ?></td>
                <td><?= $tipo; ?></td>
                <?php
                if ($tipoProf == "A") {
                    ?>
                    <td>
                        <a href='removeProfessor.php?remover=<?= $id; ?>'><i class='glyphicon glyphicon-remove'></i></a>
                        <a href='editaProfessor.php?editar=<?= $id; ?>'><i class='glyphicon glyphicon-pencil'></i></a>
                    </td>
                    <?php
                }
                ?>
            </tr> 
        <?php }
        ?>
    </table>
</fieldset>
<?php
include("../inc/paginacao.php");
include("../inc/footer.php");
?>