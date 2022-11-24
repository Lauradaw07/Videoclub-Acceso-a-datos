<?php
namespace Dwes\Util;

class SoporteNoEncontradoException extends \Exception {
    
    public function escribirError() {
        echo "No se ha encontrado el soporte";
    }
}
?>