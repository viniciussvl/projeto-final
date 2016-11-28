<?php

include("../config.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
} else {
    $id = $_GET['id'];
    $query = odbc_exec($db, "SELECT codArea FROM Assunto WHERE codArea = '$id'");
    
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        if (odbc_num_rows($query) > 0) {
            header("Location: index.php?relacionado=true");
        } else{
            $query = odbc_exec($db, "DELETE FROM Area WHERE codArea = '$id'");
            header("Location: index.php?removido=true");
        }
    }
}