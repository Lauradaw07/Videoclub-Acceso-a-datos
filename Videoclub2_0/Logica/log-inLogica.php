<?php
use Dwes\Util\CamposVaciosException;
use Dwes\Util\CredencialesErroneasException;

    include "./database.inc.php";
    require_once "../Dwes/Util/CamposVaciosException.php";
    require_once "../Dwes/Util/CredencialesErroneasException.php";

    $email = $_POST['email'];
    $clave = $_POST['clave'];

    $email = trim($email);
    $clave = trim($clave);
    
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

                header('Location: ../Vistas/pagina-principal-usuario.php');
            } else {
                try {
                    throw new CredencialesErroneasException;
                } catch(CredencialesErroneasException $e) {
                    $e -> mostrarAlerta();
                }

            }


        } catch(PDOException $e) {
            echo $e -> getMessage();
        }
    } else {
        try{
            throw new CamposVaciosException;
        } catch(CamposVaciosException $e) {
            $e -> mostrarAlerta();
            header('Location: ../Vistas/log-in.php');
        }
        header('Location: ../Vistas/log-in.php');
    }
?>