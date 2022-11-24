<?php
namespace Dwes\Util;

class CupoSuperadoException extends \Exception {

    public function escribirError() {
        echo "Has alcanzado el límite de alquilados";
    }
}
?>