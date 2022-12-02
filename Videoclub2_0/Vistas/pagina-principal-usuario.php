<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS-->
    <link rel="stylesheet" href="../Estilos/EstilosPaginaPrincipal.css">
    <!--CSS Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <!--JS Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <title>Página usuario</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-2 mt-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-12 d-flex justify-content-center">
                                <img src="../Images/Perfil.png" alt="Imagen no disponible" width="80px" height="80px">
                            </div>

                            <div class="col-12 col-lg-12">
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

                                <h4 class="text-center">Datos personales</h4>
                                <hr>

                                <span><b>Nombre:</b></span>
                                <p><?=$nombre?></p>
                                <span><b>Usuario:</b></span>
                                <p><?=$nombreUsuario?></span>
                                <p><b>Email:</b> <?=$emailAlmacenado?></p>
                            </div>

                            <div class="col-12 col-lg-12 d-flex justify-content-center align-items-center">
                                <form action='' method='post'><button name='logOut' type='submit' id="botonCerrarSesion" class="btn btn-secondary btn-lg botonCerrarSesion">Cerrar sesión</button></form>
                            </div>
                            
                            <?php
                                if(isset($_POST['logOut'])) {
                                    session_destroy();
                                    header('Location: ./log-in.php');
                                }
                            ?>

                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-10">
                <div class="row">
                    <div class="col-12 col-lg-12 mt-3  d-flex justify-content-end">                        
                        <a href="listado.php" class="me-3"><button class="btn btn-info me-5"><img src="../Images/listado.png" alt="Imagen no disponible" width="50px"> Ver listado </button></a>
                    </div>
                </div> 
                
                <div class="row">
           
                    <div class="col-12 col-lg-12 mt-4 mb-4 d-flex justify-content-center">
                        <h2>Productos alquilados:</h2>
                    </div>

                    <div class="col-12 col-lg-12">
                    <?php
                        if (isset($_SESSION['productoDevuelto'])) {
                            $existeProductoDevuelto = $_SESSION['productoDevuelto'];
                        }

                        if(isset($existeProductoDevuelto) && $existeProductoDevuelto) {?>
                       
                        <div class="row">
                            <div class="col-12 col-lg-12 d-flex justify-content-center">
                                <div class="alert alert-success alert-dismissible fade w-50 show" role="alert">
                                    Producto devuelto con éxito.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    <?php } 
                        $_SESSION['productoDevuelto'] = false;
                        // header('Location: ./pagina-principal-usuario.php');
                    ?>
                    </div>

                    <div class="col-12 col-lg-12">
                        <div class="container">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                    <th scope="col">Título</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col" class="d-flex align-items-center">
                                        Fecha alquiler
                                        <form method="post" action="">
                                            <input type="hidden" name="btnOrd2" value='ORDER BY alquileres.fechaAlquiler ASC'>
                                            <button class="ms-2 btn btn-info" type='submit'><i class="bi bi-chevron-up"></i></button>
                                        </form>
                                        
                                        <form method="post" action="">
                                            <input type="hidden" name="btnOrd2" value='ORDER BY alquileres.fechaAlquiler DESC'>
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
                                                        
                                        $sql = 'SELECT * FROM soporte INNER JOIN alquileres on (soporte.id = alquileres.idSoporte) AND (alquileres.idCliente = ?) AND (soporte.alquilado LIKE 1) GROUP BY soporte.id ' . (isset($_POST['btnOrd2']) ? $_POST['btnOrd2']:"");
                                                        
                                        $sentencia = $conexion -> prepare($sql);
                                        $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                                        $sentencia -> execute([$usuario['idCliente']]);
                                                        
                                        $soportes = $sentencia -> fetchAll();
                                                        
                                        if(isset($soportes)){
                                            foreach($soportes as $soporte) {
                                                echo "<tr>";
                                                echo "<td>".$soporte['titulo']."</td><td>".$soporte['precio']." €</td><td>".$soporte['fechaAlquiler']."</td><td><form action='../Logica/devolver.php' method='post'><input name='id' type='hidden' value='".$soporte['id']."'><button type='submit' class='btn btn-danger botonDevolver'>Devolver</button></form></td></tr>";
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

                <hr>

                <div class="row">
                    <div class="col-12 col-lg-12 mt-4 mb-4 d-flex justify-content-center">
                        <h2>Histórico de productos:</h2>
                    </div>

                    <?php
                        if (isset($_SESSION['informeGenerado'])) {
                            $existeInformeGenerado = $_SESSION['informeGenerado'];
                        }

                        if(isset($existeInformeGenerado) && $existeInformeGenerado) {?>
                       
                        <div class="row">
                            <div class="col-12 col-lg-12 d-flex justify-content-center">
                            <div class="alert alert-success alert-dismissible fade w-50 show" role="alert">
                                Informe generado con éxito.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                <?php }
                        $_SESSION['informeGenerado'] = false;

                        if (isset($_SESSION['errorGenerarInforme'])) {
                            $existeErrorGenerarInforme = $_SESSION['errorGenerarInforme'];
                        }

                        if(isset($existeErrorGenerarInforme) && $existeErrorGenerarInforme) {?>

                            <div class="row">
                                <div class="col-12 col-lg-12 d-flex justify-content-center">
                                    <div class="alert alert-danger alert-dismissible fade w-50 show" role="alert">
                                        No se ha podido generar el informe, histórico vacío.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                  <?php }

                        $_SESSION['errorGenerarInforme'] = false;?>

                    <div  id="tablahistoricoproductos" class="col-12 col-lg-12">
                        <div class="container">
                            <table  class="table table-striped">
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
                    
                    <div class="col-12 col-lg-12 mt-3 mb-3 d-flex justify-content-center">
                        <form method='post' action='../Informes/generarInforme.php'>
                            <input name='usuario' type='hidden' value='<?=$usuario["usuario"]?>'>
                            <input name='idCliente' type='hidden' value='<?=$usuario["idCliente"]?>'>
                            <button type='submit' class="btn btn-info">Generar Informe</button>
                        </form>
                
                    </div>

                </div>

            </div>
        </div>

    </div>
</body>
</html>