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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <title>Página usuario</title>
    <?php
        if(isset($_POST['logOut'])) {
            session_destroy();
            header('Location: ./log-in.html');
        }
    ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-10">
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

                            <div class="col-12 col-lg-2 d-flex justify-content-center align-items-center">
                                <form action='' method='post'><button name='logOut' type='submit' class="btn btn-secondary btn-lg">Cerrar sesión</button></form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-12 mt-4 mb-4 d-flex justify-content-center">
                <h2>Histórico de productos:</h2>
            </div>

            <div class="col-12 col-lg-12">
                <div class="container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                              <th scope="col">Título</th>
                              <th scope="col">Precio</th>
                              <th scope="col" class="d-flex justify-content-center align-items-center">
                                Fecha alquiler
                                <form method="post" action="">
                                    <input type="hidden" name="btnOrd" value='ORDER by fechaAlquiler ASC'>
                                    <button class="ms-2 btn btn-info" type='submit'><i class="bi bi-chevron-up"></i></button>
                                </form>
                                
                                <form method="post" action="">
                                    <input type="hidden" name="btnOrd" value='ORDER by fechaAlquiler DESC'>
                                    <button class="ms-2 btn btn-info" type="submit"><i class="bi bi-chevron-down"></i></button>
                                </form>
                              </th>
                            </tr>
                        </thead>
    
                        <tbody>
                        <?php
                        
                            $conexion = null;

                            try {
                                                
                                $conexion = new PDO(DSN, USUARIO, CLAVE);
                                $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                
                                $sql = 'SELECT * FROM soporte INNER JOIN alquileres on (soporte.id = alquileres.idSoporte) AND (alquileres.idCliente = ?)' . (isset($_POST['btnOrd']) ? $_POST['btnOrd']:"");
                                                
                                $sentencia = $conexion -> prepare($sql);
                                $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                                $sentencia -> execute([$usuario['idCliente']]);
                                                
                                $soportes = $sentencia -> fetchAll();
                                                
                                if(isset($soportes)){
                                    foreach($soportes as $soporte) {
                                        echo "<tr>";
                                        echo "<td>".$soporte['titulo']."</td><td>".$soporte['precio']." €</td><td class='d-flex justify-content-center'>".$soporte['fechaAlquiler']."</td></tr>";
                                    }
                                }
                            
                            } catch(PDOException $e) {
                                echo $e -> getMessage();
                            }
                        ?>
                        </tbody>
                    </table>    
                </div>
            </div>

            <div class="col-12 col-lg-12 d-flex justify-content-center">
                <form method='post' action='../Informes/generarInforme.php'>
                    <input name='usuario' type='hidden' value='<?=$usuario["usuario"]?>'>
                    <input name='idCliente' type='hidden' value='<?=$usuario["idCliente"]?>'>
                    <button type='submit' class="btn btn-info">Generar Informe</button>
                </form>
                
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-12 mt-4 mb-4 d-flex justify-content-center">
                <h2>Productos alquilados:</h2>
            </div>

            <div class="col-12 col-lg-12">
            <div class="container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                              <th scope="col">Título</th>
                              <th scope="col">Precio</th>
                              <th scope="col" class="d-flex justify-content-center align-items-center">
                                Fecha alquiler
                                <form method="post" action="">
                                    <input type="hidden" name="btnOrd2" value='ORDER by fechaAlquiler ASC'>
                                    <button class="ms-2 btn btn-info" type='submit'><i class="bi bi-chevron-up"></i></button>
                                </form>
                                
                                <form method="post" action="">
                                    <input type="hidden" name="btnOrd2" value='ORDER by fechaAlquiler DESC'>
                                    <button class="ms-2 btn btn-info" type="submit"><i class="bi bi-chevron-down"></i></button>
                                </form>
                               </th>
                               <th></th>
                            </tr>
                        </thead>
    
                        <tbody>
                        <?php
                        
                            $conexion = null;

                            try {                
                                $conexion = new PDO(DSN, USUARIO, CLAVE);
                                $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                
                                $sql = 'SELECT * FROM soporte INNER JOIN alquileres on (soporte.id = alquileres.idSoporte) AND (alquileres.idCliente = ?) AND (soporte.alquilado LIKE 1) AND alquileres.fechaAlquiler = (SELECT MAX(fechaAlquiler) FROM alquileres)' . (isset($_POST['btnOrd2']) ? $_POST['btnOrd2']:"");
                                                
                                $sentencia = $conexion -> prepare($sql);
                                $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                                $sentencia -> execute([$usuario['idCliente']]);
                                                
                                $soportes = $sentencia -> fetchAll();
                                                
                                if(isset($soportes)){
                                    foreach($soportes as $soporte) {
                                        echo "<tr>";
                                        echo "<td>".$soporte['titulo']."</td><td>".$soporte['precio']." €</td><td class='d-flex justify-content-center'>".$soporte['fechaAlquiler']."</td><td><form action='../Logica/devolver.php' method='post'><input name='id' type='hidden' value='".$soporte['id']."'><button type='submit' class='btn btn-danger'>Devolver</button></form></td></tr>";
                                    }
                                }
                            
                            } catch(PDOException $e) {
                                echo $e -> getMessage();
                            }
        
                        ?>

                        </tbody>
                    </table>    
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