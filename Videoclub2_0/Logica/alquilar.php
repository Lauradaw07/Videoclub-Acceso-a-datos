<?php

    include "./database.inc.php";

    session_start();
    $email = $_SESSION['email'];
    $idSoporte = $_POST['idSoporte'];
    $idUsuario = null;

    $conexion = null;

        try {
            $conexion = new PDO(DSN, USUARIO, CLAVE);
            $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Obtenemos id del cliente
            $consultaidUsuario = "SELECT idCliente FROM usuarios WHERE email = ?";
            $sentencia = $conexion -> prepare($consultaidUsuario);
            $sentencia -> execute([$email]);

            $usuario = $sentencia -> fetch();
            
            $idUsuario = $usuario['idCliente'];

            //Obtenemos los datos de alquiler cliente
            $consultaCliente = 'SELECT * FROM cliente WHERE id = ?';
            $sentencia2 = $conexion -> prepare($consultaCliente);
            $sentencia2 -> execute([$idUsuario]);
            
            $cliente = $sentencia2 -> fetch();

            if($cliente) {
                if($cliente['numeroSoportesAlquilados'] < $cliente['maxAlquileres']) {
                    //Actualizamos el soporte a alquilado
                    $consultaActualizarAlquilado = "UPDATE soporte SET alquilado = 1 WHERE id = ?";
                    $sentencia3 = $conexion -> prepare($consultaActualizarAlquilado);
                    $sentencia3 -> execute([$idSoporte]);

                    //Insertamos registro en alquileres
                    $consultaInsertarAlquiler = "INSERT INTO alquileres VALUES(?,NOW(),?)";
                    $sentencia4 = $conexion -> prepare($consultaInsertarAlquiler);
                    $sentencia4 -> execute([$idUsuario,$idSoporte]);

                    //Sumamos un soporte a los soportes alquilados por el cliente
                    $consultaActualizarSoportesAlquilados = 'UPDATE cliente SET numeroSoportesAlquilados = (? + 1) WHERE id = ?';
                    $sentencia5 = $conexion -> prepare($consultaActualizarSoportesAlquilados);
                    $sentencia5 -> execute([$cliente['numeroSoportesAlquilados'], $idUsuario]);
            
                }
            }
        
            header('Location: ../Vistas/listado.php');
        
        } catch(PDOException $e) {
            echo $e -> getMessage();
        }
    
?>