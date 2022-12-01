<?php
    include "./database.inc.php";

    session_start();
    $email = $_SESSION['email'];
    $idSoporte = $_POST['id'];

    $conexion = null;

    try {
        $conexion = new PDO(DSN, USUARIO, CLAVE);
        $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Obtenemos el id del usuario
        $consultaidUsuario = "SELECT * FROM usuarios WHERE email = ?";
        $sentencia = $conexion -> prepare($consultaidUsuario);
        $sentencia -> execute([$email]);

        $usuario = $sentencia -> fetch();
        $idUsuario = $usuario['idCliente'];

        //Devolvemos el producto
        $consultaDevolver = "UPDATE soporte SET alquilado = 0 WHERE id = ?";
        $sentencia2 = $conexion -> prepare($consultaDevolver);
        $sentencia2 -> execute([$idSoporte]);

        //Restamos un soporte a los soportes alquilados por el cliente
        $consultaActualizarSoportesAlquilados = 'UPDATE cliente SET numeroSoportesAlquilados = (? - 1) WHERE id = ?';
        $sentencia3 = $conexion -> prepare($consultaActualizarSoportesAlquilados);
        $sentencia3 -> execute([$cliente['numeroSoportesAlquilados'], $idUsuario]);

        header('Location: ../Vistas/pagina-principal-usuario.php');

    } catch(PDOException $e) {
        echo $e -> getMessage();
    }

?>