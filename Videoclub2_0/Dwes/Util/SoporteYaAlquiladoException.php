<?php
namespace Dwes\Util;

    class SoporteYaAlquiladoException extends \Exception {

        public function escribirError() {
            echo "El soporte ya está alquilado";
        }
    }

?>