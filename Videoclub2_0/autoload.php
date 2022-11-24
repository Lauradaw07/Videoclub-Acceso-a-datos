<?php

    spl_autoload_register( function($nombreClase) {

        $partes = explode('\\', $nombreClase);
        $claseIncluida = end($partes) . ".php";
        include_once "Dwes/" . $claseIncluida;
    });

?>