<?php
    include "./database.inc.php";

    $email = $_POST['email'];
    $clave = $_POST['clave'];
    
    if(($email != "") && ($clave != "")) {
        $conexion = null;

        try {
            $conexion = new PDO(DSN, USUARIO, CLAVE);
            $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM usuarios WHERE email = ?";
            $sentencia = $conexion -> prepare($sql);
            // $sentencia -> bindParam(1, $email);
            // $sentencia -> bindParam(2, $clave);
            $sentencia -> execute([$email]);

            $usuario = $sentencia -> fetch();

            if($usuario && password_verify($clave, $usuario['clave'])) {
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['clave'] = $clave;
                
                echo "Todo bien";
            } else {
                echo "NOP"; //PONER ALERTA
            }


        } catch(PDOException $e) {
            echo $e -> getMessage();
        }
    } else {
        header('Location: ../Vistas/log-in.html');
    }
?>