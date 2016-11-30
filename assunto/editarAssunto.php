<?php
error_reporting(0);
session_start();
if (!isset($_GET['id']) && !is_numeric($_GET['id'])) {
    header("Location: index.php");
}
include("../config.php");
$id = $_GET['id'];
$query = odbc_exec($db, "SELECT codAssunto, Assunto.descricao AS 'assunto', Assunto.codArea, Area.descricao
                         FROM Assunto
                            INNER JOIN Area
                                ON Assunto.codArea = Area.codArea
                         WHERE codAssunto = '$id'");

while ($row = odbc_fetch_array($query)) {
    $assunto = $row['assunto'];
    $area = $row['codArea'];
}
$listarAreas = odbc_exec($db, "SELECT codArea, descricao FROM Area");
if (isset($_POST['descricao']) && isset($_POST['area'])) {
    $cdArea = $_SESSION['codArea'];
    $assunto = $_POST['descricao'];
    $query = odbc_exec($db, "UPDATE Assunto SET descricao = '$assunto', codArea = '$cdArea' WHERE codAssunto = '$id'");
    header("Location:index.php");
}

echo "<div class='container'>";
include("../inc/header.php");


?>

<form method="POST" class="form-horizontal">
    <div class="form-group">

        <div class="col-sm-5">
            <select name="area" class="form-control" >
                <?php
                while ($row = odbc_fetch_array($listarAreas)) {
                    $codArea = $row['codArea'];
                    $descricao = $row['descricao'];

                    if ($area == $codArea) {
                        $selected = 'selected';
                    } else {
                        $selected = '';
                    }
                    echo "<option value='$codArea' $selected>$descricao</option>";
                }
                ?>
            </select> 
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-5">
            <input type="text" class="form-control" value="<?= $assunto; ?>" name="descricao">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-5">
            <button type="submit" class="btn btn-success">Editar assunto</button>
        </div>
    </div>
</form>
<?php

$_SESSION['codArea'] = $_POST['area'];
include("../inc/footer.php");
?>