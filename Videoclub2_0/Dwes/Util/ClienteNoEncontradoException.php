<?php
namespace Dwes\Util;

class ClienteNoEncontradoException extends \Exception {

    public function escribirError() {
        echo "Cliente no encontrado";
    }
}
?>