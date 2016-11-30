<?php
if(!isset($_GET['id']) && !is_numeric($_GET['id'])){
    header("Location: index.php");
} else{
    include("../config.php");
    $id = $_GET['id'];
    $query = odbc_exec($db, "SELECT codArea, descricao FROM Area WHERE codArea = '$id'");
    while($row = odbc_fetch_array($query)){
        $descricaoArea = $row['descricao'];
    }  
    echo "<div class='container'>";

    if(isset($_POST['descricao'])){
        $novaDescricao = $_POST['descricao'];
    $query = odbc_exec($db, "UPDATE Area SET descricao = '$novaDescricao' WHERE codArea = $id");
        header("Location: index.php?editado=true");
    }
    
    include("../inc/header.php");

?>

<form id="editarArea" class="form-horizontal" method="POST">
    <div class="form-group">
        <label for="descricao" class="col-sm-2 control-label">&Aacute;rea:</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="descricao" value="<?= $descricaoArea; ?>">
            <input type="submit" class="btn btn-primary" value="Editar">
        </div>
    </div>
</form>

<?php
    
    include("../inc/footer.php");
}

    

?>