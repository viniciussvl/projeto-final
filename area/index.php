<?php
include("../config.php");

$query = odbc_exec($db, 'SELECT count(*) AS qtd FROM Area');
$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
$cont = odbc_fetch_array($query);
$registros = 10;
$numPaginas = ceil($cont['qtd']/$registros);
$inicio = ($registros * $pagina) - $registros;
if($pagina > $numPaginas || $pagina <= 0){
    header("Location: index.php?pagina=1");
} 

// FILTRO
$desc = "descA";
$ordenar = "codArea DESC";

if (isset($_GET['filtro'])) {
    $filtro = $_GET['filtro'];
    switch ($filtro) {
        case ('descA'):
            $ordenar = "descricao";
            break;
        case ('descD'):
            $ordenar = "descricao DESC";
            break;
    }
    // Filtrar por crescente e decrescente
    if ($filtro == "descA") {
        $desc = "descD";
    } else {
        $desc = "descA";
    }
}

include("../inc/header.php");

echo "<div class='container'>";

$query = odbc_exec($db, "SELECT codArea, descricao FROM Area ORDER BY $ordenar OFFSET $inicio ROWS FETCH NEXT $registros ROWS ONLY");

if (isset($_GET['removido']) && $_GET['removido'] == 'true') {
    echo "<div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
  &Aacute;rea removida com sucesso!
</div>";
} else if (isset($_GET['relacionado']) && $_GET['relacionado'] == 'true') {
    echo "<p class='alert alert-danger'>Erro! A &Aacute;rea n&atilde;o pode ser removida pois existe um assunto relacionado a ela!</p>";
}

if (isset($_GET['editado']) && $_GET['editado'] == 'true') {
    echo "<p class='alert alert-success'>&Aacute;rea editado com succeso!</p>";
}
?>



<div class="col-md-10 col-md-offset-1">
    <a data-toggle="modal" data-target="#modalArea" class="right btn btn-success"><i class="glyphicon glyphicon-plus"></i>Nova &Aacute;rea</a>
    <div class="clearfix"></div>
    
    <fieldset>
        <legend>&Aacute;reas</legend>
        <div class="col-md-12">
            <table class="tabela table table-bordered table-striped">
                <tr>
                    <th> 
                        <a href="index.php?pagina=<?= $pagina; ?>&filtro=<?= $desc; ?>">Descri&ccedil;&atilde;o
<?php
if ($desc == "descA") {
    echo "<i class='glyphicon glyphicon-triangle-bottom'></i>";
} else {
    echo "<i style='color:#84c754;' class='glyphicon glyphicon-triangle-top'></i>";
}
?>
                </a></th>
                    <th>Op&ccedil;&otilde;es</th>
                </tr> 
                <?php
                while ($areas = odbc_fetch_array($query)) {
                    $codArea = $areas['codArea'];
                    $descricao = $areas['descricao'];
                    ?>
                    <tr>
                        <td><?= $descricao; ?></td>
                        <td>
                            <a href='deletarArea.php?id=<?= $codArea; ?>' onclick="return confirm('Deseja realmente excluir a &Aacute;rea selecionada?')"><i class='glyphicon glyphicon-remove'></i></a>
                            <a href='editarArea.php?id=<?= $codArea; ?>'><i class='glyphicon glyphicon-pencil'></i></a>
                        </td>
                    </tr>
                <?php }
                ?>
            </table>
        </div>
    </fieldset>
    
    <!-- PAGINA&ccedil;&atilde;O -->
    
    <?php
        include("../inc/paginacao.php");
    ?>
</div>

<?php include("../inc/footer.php"); ?>
