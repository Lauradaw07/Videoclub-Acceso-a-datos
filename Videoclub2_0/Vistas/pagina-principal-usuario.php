<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <!--JS Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Página usuario</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                            include "../Logica/database.inc.php";
                            $conexion = null;

                            session_start();
                            $email = $_SESSION['email'];
                            try {
                                $conexion = new PDO(DSN, USUARIO, CLAVE);
                                $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                                $sql = "SELECT * FROM usuarios WHERE email = ?";
                                $sentencia = $conexion -> prepare($sql);
                                $sentencia -> execute([$email]);
                
                                $usuario = $sentencia -> fetch();

                                if($usuario) {
                                    $nombre = $usuario['nombre'];
                                    $nombreUsuario = $usuario['usuario'];
                                    $emailAlmacenado = $usuario['email']; 
                                }
                            } catch(PDOException $e) {
                                echo $e -> getMessage();
                            }    
                        ?>

                        <h2>Perfil:</h2>

                        <p><b>Nombre:</b> <?=$nombre?></p>
                        <p><b>Usuario:</b> <?=$nombreUsuario?></p>
                        <p><b>Email:</b> <?=$emailAlmacenado?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-12">
                <a href="listado.php">Ver productos</a>
            </div>
        </div>
    </div>
</body>
</html>