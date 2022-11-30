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
                              <th scope="col">Fecha alquiler</th>
                            
                            </tr>
                        </thead>
    
                        <tbody>
                        <?php
                        
                            $conexion = null;

                            try {
                                                
                                $conexion = new PDO(DSN, USUARIO, CLAVE);
                                $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                
                                $sql = 'SELECT * FROM soporte INNER JOIN alquileres on (soporte.id = alquileres.idSoporte) AND (alquileres.idCliente = ?)';
                                                
                                $sentencia = $conexion -> prepare($sql);
                                $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                                $sentencia -> execute([$usuario['idCliente']]);
                                                
                                $soportes = $sentencia -> fetchAll();
                                                
                                if(isset($soportes)){
                                    foreach($soportes as $soporte) {
                                        echo "<tr>";
                                        echo "<td>".$soporte['titulo']."</td><td>".$soporte['precio']." €</td><td>".$soporte['fechaAlquiler']."</td></tr>";
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
                              <th scope="col">Fecha alquiler</th>
                            </tr>
                        </thead>
    
                        <tbody>
                        <?php
                        
                            $conexion = null;

                            try {
                                                
                                $conexion = new PDO(DSN, USUARIO, CLAVE);
                                $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                
                                $sql = 'SELECT * FROM soporte INNER JOIN alquileres on (soporte.id = alquileres.idSoporte) AND (alquileres.idCliente = ?) AND (soporte.alquilado LIKE 1)';
                                                
                                $sentencia = $conexion -> prepare($sql);
                                $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                                $sentencia -> execute([$usuario['idCliente']]);
                                                
                                $soportes = $sentencia -> fetchAll();
                                                
                                if(isset($soportes)){
                                    foreach($soportes as $soporte) {
                                        echo "<tr>";
                                        echo "<td>".$soporte['titulo']."</td><td>".$soporte['precio']." €</td><td>".$soporte['fechaAlquiler']."</td></tr>";
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