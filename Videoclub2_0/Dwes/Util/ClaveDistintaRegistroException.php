<?php
namespace Dwes\Util;

class ClaveDistintaRegistroException extends \Exception {

    public function mostrarAlerta() {
        session_start();
        $_SESSION['errorClaveDistinta'] = true;
        header('Location: ../Vistas/registro.php');
    }
}
?>
