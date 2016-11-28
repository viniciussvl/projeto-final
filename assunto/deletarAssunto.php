<?php
include("../config.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
} else {
    $id = $_GET['id'];
    $query = odbc_exec($db, "SELECT codAssunto FROM Assunto WHERE codAssunto = {$id}");
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $query = odbc_exec($db, "DELETE FROM Assunto WHERE codAssunto = {$id}");
        header("Location: index.php?removido=true");
    }
}


