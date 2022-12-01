<?php
    include "./database.inc.php";

    // if(isset($_POST['id'])){
        echo "ENTRA";
        $idSoporte = $_POST['id'];

        $conexion = null;

        try {

            $conexion = new PDO(DSN, USUARIO, CLAVE);
            $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $consultaDevolver = "UPDATE soporte SET alquilado = 0 WHERE id = ?";
            $sentencia = $conexion -> prepare($consultaDevolver);
            $sentencia -> execute([$idSoporte]);

            header('Location: ../Vistas/pagina-principal-usuario.php');

        } catch(PDOException $e) {
            echo $e -> getMessage();
        }
    // }

    
    

?>