<?php

    include "./database.inc.php";

    session_start();
    $email = $_SESSION['email'];
    $idSoporte = $_POST['idSoporte'];
    $idCliente = null;

    $conexion = null;

        try {
            $conexion = new PDO(DSN, USUARIO, CLAVE);
            $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Recogida de id del cliente
            $consultaIdCliente = "SELECT idCliente FROM usuarios WHERE email = ?";
            $sentencia = $conexion -> prepare($consultaIdCliente);
            $sentencia -> execute([$email]);
            $usuario = $sentencia->fetch();

            if($usuario) {
                $idCliente = $usuario['idCliente'];
            }

            //Actualizamos el soporte a alquilado
            $consultaActualizarAlquilado = "UPDATE soporte SET alquilado=1 WHERE id = ?";
            $sentencia2 = $conexion -> prepare($consultaActualizarAlquilado);
            $sentencia2 -> execute([$idSoporte]);

            //Insertamos registro en alquileres
            $consultaInsertarAlquiler = "INSERT INTO alquileres VALUES(?,NOW(),?)";
            $sentencia3 = $conexion -> prepare($consultaInsertarAlquiler);
            $sentencia3 -> execute([$idCliente,$idSoporte]);
        
            header('Location: ../Vistas/listado.php');
        
        } catch(PDOException $e) {
            echo $e -> getMessage();
        }
    
?>