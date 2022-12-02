<?php
namespace Dwes\Util;

class NoHistoricoException extends \Exception {

    public function mostrarAlerta() {
        session_start();
        $_SESSION['errorGenerarInforme'] = true;

        header('Location: ../Vistas/pagina-principal-usuario.php');
    }
}
?>