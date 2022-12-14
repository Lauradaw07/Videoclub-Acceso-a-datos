<?php

use Dwes\Util\ClaveDistintaRegistroException;
use Dwes\Util\EmailYaRegistradoException;
use Dwes\Util\CamposVaciosException;

    require_once "../Dwes/Util/ClaveDistintaRegistroException.php";
    require_once "../Dwes/Util/EmailYaRegistradoException.php";
    require_once "../Dwes/Util/CamposVaciosException.php";

    include "./database.inc.php";

    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $clave = $_POST['clave'];
    $comprobacionClave = $_POST['comprobacionClave'];
    $error = false;

    $nombre = trim($nombre);
    $usuario = trim($usuario);
    $email = trim($email);
    $clave = trim($clave);
    $comprobacionClave = trim($comprobacionClave);
    
    if(($nombre != "") && ($usuario != "") && ($email != "") && ($clave != "") && ($comprobacionClave != "")) {
        try{
            if($clave != $comprobacionClave) {
                throw new ClaveDistintaRegistroException();
            }
            
        } catch(ClaveDistintaRegistroException $e) {
            echo $e -> mostrarAlerta();
        }
        
        if($clave === $comprobacionClave) {
            
            $conexion = null;
    
            try {
    
                $conexion = new PDO(DSN, USUARIO, CLAVE);
                $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                $sql = "SELECT * FROM usuarios WHERE email = ?";
                $sentencia = $conexion -> prepare($sql);
                $sentencia -> execute([$email]);
    
                $usuarioEncontrado = $sentencia -> fetch();
    
                if(!$usuarioEncontrado) {
                    try {
                        $aleatorio = rand(1, 9) * round(microtime(true) * 1000);
                        $id = intval(substr($aleatorio, 0, 8));
    
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
    
                        echo "El usuario ".$usuario." ha sido introducido en el sistema con la contrase??a ".$clave;

                        session_start();
                        $_SESSION['usuarioRegistrado'] = true;
    
                        header('Location: ../Vistas/log-in.php');
    
                    } catch(PDOException $e) {
                        echo $e -> getMessage();
                    }
                } else {
                    try{
                        throw new EmailYaRegistradoException;
                    } catch(EmailYaRegistradoException $e){
                        $e -> mostrarAlerta();
                    }
                }
    
            } catch(PDOException $e) {
                echo $e -> getMessage();
            }
        } 
    } else {
        try{
            throw new CamposVaciosException;
        } catch(CamposVaciosException $e) {
            $e -> mostrarAlerta();
            header('Location: ../Vistas/registro.php');
        }
        header('Location: ../Vistas/registro.php');
    }
?>