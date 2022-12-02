<?php
namespace Dwes\Util;

class CamposVaciosException extends \Exception {

    public function mostrarAlerta() {
        session_start();
        $_SESSION['errorCamposVacios'] = true;
    }
}
?>