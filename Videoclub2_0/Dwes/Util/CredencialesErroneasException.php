<?php
namespace Dwes\Util;

class CredencialesErroneasException extends \Exception {

    public function mostrarAlerta() {
        session_start();
        $_SESSION['credencialesErroneas'] = true;
        header('Location: ../Vistas/log-in.php');
    }
}
?>