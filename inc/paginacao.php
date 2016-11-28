<?php
if (isset($_GET['nome'])) {
    $nomeProf = $_GET['nome'];
}

if (isset($_GET['n'])) {
    $idAssunto = $_GET['n'];
}
?>
<!-- PAGINAÇÃO -->
<ul class="pagination"> 
    <?php
    if ($pagina == 1) {
        echo "<li class='disabled'><a href='#' aria-label='Previous'>
        <span aria-hidden='true'>&laquo;</span>
      </a></li>";
    } else {
        $pagAnterior = $pagina - 1;
        if (isset($filtro)) {
            if (isset($nomeProf) && !empty($nomeProf)) {
                echo "<li><a href='index.php?pagina=$pagAnterior&filtro=$filtro&nome=$nomeProf' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
            } else {
                if (isset($idAssunto) && !empty($idAssunto)) {
                    echo "<li><a href='index.php?pagina=$pagAnterior&filtro=$filtro&n=$idAssunto' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
                } else {
                    echo "<li><a href='index.php?pagina=$pagAnterior&filtro=$filtro' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
                }
            }
        } else {
            echo "<li><a href='index.php?pagina=$pagAnterior' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
        }
    }
    for ($i = 1; $i < $numPaginas + 1; $i++) {
        if ($pagina == $i) {
            if (isset($filtro)) {
                if (isset($nomeProf) && !empty($nomeProf)) {
                    echo "<li class='active'><a href='index.php?pagina=$i&filtro=$filtro&nome=$nomeProf'>" . $i . "</a></li>";
                } else {
                    if (isset($idAssunto) && !empty($idAssunto)) {
                        echo "<li class='active'><a href='index.php?pagina=$i&filtro=$filtro&n=$idAssunto'>" . $i . "</a></li>";
                    } else {
                        echo "<li class='active'><a href='index.php?pagina=$i&filtro=$filtro'>" . $i . "</a></li>";
                    }
                }
            } else {
                echo "<li class='active'><a href='index.php?pagina=$i'>" . $i . "</a></li>";
            }
        } else {
            if (isset($filtro)) {
                if (isset($nomeProf) && !empty($nomeProf)) {
                    echo " <li class='waves-effect'><a href='index.php?pagina=$i&filtro=$filtro&nome=$nomeProf'>" . $i . "</a></li> ";
                } else {
                    if (isset($idAssunto) && !empty($idAssunto)) {
                        echo " <li class='waves-effect'><a href='index.php?pagina=$i&filtro=$filtro&n=$idAssunto'>" . $i . "</a></li> ";
                    } else {
                        echo " <li class='waves-effect'><a href='index.php?pagina=$i&filtro=$filtro'>" . $i . "</a></li> ";
                    }
                }
            } else {
                echo " <li class='waves-effect'><a href='index.php?pagina=$i'>" . $i . "</a></li> ";
            }
        }
    }
    if ($pagina == $numPaginas) {
        echo "<li class='disabled'><a href='javascript:void(0)' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
    } else {
        $pagAnterior = $pagina + 1;
        if (isset($filtro)) {
            echo "<li><a href='index.php?pagina=$pagAnterior&filtro=$filtro' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a>";
        } else {
            echo "<li><a href='index.php?pagina=$pagAnterior' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a>";
        }
    }
    ?>
</ul>