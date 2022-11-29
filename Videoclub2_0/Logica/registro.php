<?php
    include "./database.inc.php";

    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $clave = $_POST['clave'];
    $comprobacionClave = $_POST['comprobacionClave'];

    if(($nombre != "") && ($usuario != "") && ($email != "") && ($clave != "") && ($comprobacionClave != "")) {
        if($clave === $comprobacionClave) {
            $conexion = null;
    
            try {
    
                $conexion = new PDO(DSN, USUARIO, CLAVE);
                $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                $sql = "SELECT * FROM usuarios WHERE email = ?";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> execute([$email]);
    
                $usuario = $sentencia -> fetch();
    
                if(!$usuario) {
                    try {
                        $id = uniqid();
    
                        $sql = "INSERT INTO usuarios VALUES (:idCliente, :nombre, :usuario, :email, :clave)";
                        $sentencia = $conexion -> prepare($sql);
    
                        $sql2 = "INSERT INTO cliente VALUES (:id, :maxAlquileres, :numeroSoportesAlquilados)";
                        $sentencia2 = $conexion -> prepare($sql2);
    
                        $isOk = $sentencia -> execute([
                            "idCliente" => $id,
                            "nombre" => $nombre,
                            "usuario" => $usuario,
                            "email" => $email,
                            "clave" => password_hash($clave, PASSWORD_DEFAULT)
                        ]);
    
                        $isOk = $sentencia2 -> execute([
                            "id" => $id,
                            "maxAlquileres" => 3,
                            "numeroSoportesAlquilados" => 0
                        ]);
    
                        echo "El usuario ".$usuario." ha sido introducido en el sistema con la contraseña ".$clave;
    
                        header('Location: ../Vistas/log-in.html');
    
                    } catch(PDOException $e) {
                        echo $e -> getMessage();
                    }
                }
    
            } catch(PDOException $e) {
                echo $e -> getMessage();
            }
        }
    } else {
        header('Location: ../Vistas/log-in.html');
    }
?>