<?php
namespace Dwes\Util;

class EmailYaRegistradoException extends \Exception {

    public function mostrarAlerta() {
        session_start();
        $_SESSION['errorEmailYaRegistrado'] = true;
        header('Location: ../Vistas/registro.php');
    }
}
?>