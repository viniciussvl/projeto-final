<?php
include("../config.php");

// Paginação
$query = odbc_exec($db, "SELECT count(*) AS 'qtd' FROM Assunto");
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
$ordenar = "codAssunto DESC";

if (isset($_GET['filtro'])) {
    $filtro = $_GET['filtro'];
    switch ($filtro) {
        case ('descA'):
            $ordenar = "Assunto";
            break;
        case ('descD'):
            $ordenar = "Assunto DESC";
            break;
    }
    // Filtrar por crescente e decrescente
    if ($filtro == "descA") {
        $desc = "descD";
    } else {
        $desc = "descA";
    }
}


$query = odbc_exec($db, "SELECT ass.descricao as Assunto, are.descricao as Area, codAssunto
                               FROM Assunto AS ass 
                               INNER JOIN Area as are
                                    ON ass.codArea = are.codArea
                               ORDER BY $ordenar OFFSET $inicio ROWS FETCH NEXT $registros ROWS ONLY");

include("../inc/header.php");
echo "<div class='container'>";

if(isset($_GET['removido']) && $_GET['removido'] == 'true'){

    echo "<p class='alert alert-success'>Assunto removido com succeso!</p>";

}else if(isset($_GET['relacionado']) && $_GET['relacionado'] == 'true'){

   echo "<p class='alert alert-danger'>Erro! A uma quest&atilde;o relacionada a este assunto!</p>";   
}

if(isset($_GET['editado']) && $_GET['editado'] == 'true'){
    echo "<p class='alert alert-success'>Assunto alterado com succeso!</p>";
}

if(isset($_GET['adicionado']) && $_GET['adicionado'] == 'true'){
    echo "<p class='alert alert-success'>Assunto adicionado com succeso!</p>";
}

?>
<a data-toggle="modal" data-target="#modalAssunto" class="btn btn-success right"><i class="glyphicon glyphicon-plus"></i>Novo assunto</a>
<div class="clearfix"></div>
<fieldset>
    <legend>Assuntos</legend>
            
  <table class="tabela table table-bordered table-striped">
      <tr>
          <th><a href="index.php?pagina=<?= $pagina; ?>&filtro=<?= $desc; ?>">Descri&ccedil;&atilde;o
<?php
if ($desc == "descA") {
    echo "<i class='glyphicon glyphicon-triangle-bottom'></i>";
} else {
    echo "<i style='color:#84c754;' class='glyphicon glyphicon-triangle-top'></i>";
}
?>
                </a></th>
          <th>&Aacute;rea</th>
          <th>A&ccedil;&otilde;es</th>
      </tr>
  <?php
      while($assuntos = odbc_fetch_array($query)){
          $assunto = $assuntos['Assunto'];
          $descricao = $assuntos['Area'];
          $codAssunto = $assuntos['codAssunto'];

          echo "<tr>
                  <td>$assunto</td>
                  <td>$descricao</td>
                  <td>
                      <a href='deletarAssunto.php?id=$codAssunto'><i class='glyphicon glyphicon-remove'></i></a>
                      <a href='editarAssunto.php?id=$codAssunto'><i class='glyphicon glyphicon-pencil'></i></a>
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

<?php include("../inc/footer.php");?>
