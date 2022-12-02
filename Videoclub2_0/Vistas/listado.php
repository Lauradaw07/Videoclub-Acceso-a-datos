<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS-->
    <link rel="stylesheet" href="../Estilos/EstilosListado.css">
    <!--CSS Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <!--JS Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>

    <div class="container-fluid"></div>
        <div class="row">
            <div class="col-12 col-lg-12 mt-4 mb-4 d-flex justify-content-center">
                <h2>Productos:</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-12 d-flex justify-content-center">
                <form action="" method='post'>
                    <div class="input-group mb-3">
                        <input type="text" name='search' class="form-control" placeholder="Titanic" aria-label="Titanic" aria-describedby="basic-addon2">
                        <button class="btn btn-info" type="submit">Buscar</button>
                    </div>            
                </form>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 col-lg-12 d-flex justify-content-center">
                <h2>Juegos:</h2>
            </div>

            <div class="col-12 col-lg-12 d-flex align-items-center">
                <div class="container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                              <th scope="col">Título</th>
                              <th scope="col">Precio</th>
                              <th scope="col">Consola</th>
                              <th scope="col">minJugadores</th>
                              <th scope="col">maxJugadores</th>
                              <th scope="col">Alquilado</th>
                              <th scope="col"></th>
                            </tr>
                        </thead>
    
                        <tbody>
                        <?php
                            include "../Logica/database.inc.php";
                            $conexion = null;

                            try {
                                                
                                $conexion = new PDO(DSN, USUARIO, CLAVE);
                                $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                                
                                if(isset($_POST['search'])) {
                                    $sql = 'SELECT * FROM soporte INNER JOIN juego on soporte.id = juego.idSoporte AND soporte.titulo LIKE ?';

                                    $sentencia = $conexion -> prepare($sql);
                                    $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                                    $sentencia -> execute(["%".$_POST['search']."%"]);

                                } else {
                                    $sql = 'SELECT * FROM soporte INNER JOIN juego on soporte.id = juego.idSoporte';

                                    $sentencia = $conexion -> prepare($sql);
                                    $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                                    $sentencia -> execute();
                                }
                                                
                                $soportes = $sentencia -> fetchAll();
                                                
                                if(isset($soportes)){
                                    foreach($soportes as $soporte) {
                                        echo "<tr>";
                                        echo "<td>".$soporte['titulo']."</td><td>".$soporte['precio']."</td><td>".$soporte['consola']."</td><td>".$soporte['minNumeroJugadores']."</td><td>".$soporte['maxNumeroJugadores']."</td><td>";
                                        echo ($soporte['alquilado']) ? "No disponible":"Disponible";
                                        if($soporte['alquilado']) {
                                            echo "</td><td class='d-flex justify-content-end'><button disabled class='btn btn-success'>Alquilar</button></td>";
                                        } else {
                                            echo "</td><td class='d-flex justify-content-end'> <form method='post' action='../Logica/alquilar.php'> <input type='hidden' name='idSoporte' value='".$soporte['id']."'> <button type='submit' class='btn btn-success'>Alquilar</button> </form> </td>";
                                        }
                                        
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
            <div class="col-12 col-lg-12 mt-4 d-flex justify-content-center">
                <h2>DVD:</h2>
            </div>

            <div class="col-12 col-lg-12 d-flex align-items-center">
                <div class="container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                              <th scope="col">Título</th>
                              <th scope="col">Precio</th>
                              <th scope="col">Idiomas</th>
                              <th scope="col">Formato de Pantalla</th>
                              <th scope="col">Alquilado</th>
                              <th scope="col"></th>
                            
                            </tr>
                        </thead>
    
                        <tbody>
                        <?php
                        
                            $conexion = null;

                            try {
                                                
                                $conexion = new PDO(DSN, USUARIO, CLAVE);
                                $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                if(isset($_POST['search'])) {
                                    $sql = 'SELECT * FROM soporte INNER JOIN dvd on soporte.id = dvd.idSoporte AND soporte.titulo LIKE ?';

                                    $sentencia = $conexion -> prepare($sql);
                                    $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                                    $sentencia -> execute(["%".$_POST['search']."%"]);

                                } else {
                                    $sql = 'SELECT * FROM soporte INNER JOIN dvd on soporte.id = dvd.idSoporte';

                                    $sentencia = $conexion -> prepare($sql);
                                    $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                                    $sentencia -> execute();
                                }
                                                
                                $soportes = $sentencia -> fetchAll();
                                                
                                if(isset($soportes)){
                                    foreach($soportes as $soporte) {
                                        echo "<tr>";
                                        echo "<td>".$soporte['titulo']."</td><td>".$soporte['precio']."</td><td>".$soporte['idiomas']."</td><td>".$soporte['formatoPantalla']."</td><td>";
                                        echo ($soporte['alquilado']) ? "No disponible":"Disponible";
                                        if($soporte['alquilado']) {
                                            echo "</td><td class='d-flex justify-content-end'><button disabled class='btn btn-success'>Alquilar</button></td>";
                                        } else {
                                            echo "</td><td class='d-flex justify-content-end'> <form method='post' action='../Logica/alquilar.php'> <input type='hidden' name='idSoporte' value='".$soporte['id']."'> <button type='submit' class='btn btn-success'>Alquilar</button> </form> </td>";
                                        }
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
            <div class="col-12 col-lg-12 mt-4 d-flex justify-content-center">
                <h2>Cintas de Video:</h2>
            </div>

            <div class="col-12 col-lg-12 d-flex align-items-center">
                <div class="container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                              <th scope="col">Título</th>
                              <th scope="col">Precio</th>
                              <th scope="col">Duración</th>
                              <th scope="col">Alquilado</th>
                              <th scope="col"></th>
        
                            </tr>
                        </thead>
    
                        <tbody>
                        <?php
                            $conexion = null;

                            try {
                                                
                                $conexion = new PDO(DSN, USUARIO, CLAVE);
                                $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                if(isset($_POST['search'])) {
                                    $sql = 'SELECT * FROM soporte INNER JOIN cintavideo on soporte.id = cintavideo.idSoporte AND soporte.titulo LIKE ?';

                                    $sentencia = $conexion -> prepare($sql);
                                    $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                                    $sentencia -> execute(["%".$_POST['search']."%"]);

                                } else {
                                    $sql = 'SELECT * FROM soporte INNER JOIN cintavideo on soporte.id = cintavideo.idSoporte';

                                    $sentencia = $conexion -> prepare($sql);
                                    $sentencia -> setFetchMode(PDO::FETCH_ASSOC);
                                    $sentencia -> execute();
                                }
                                       
                                $soportes = $sentencia -> fetchAll();
                                                
                                if(isset($soportes)){
                                    foreach($soportes as $soporte) {
                                        echo "<tr>";
                                        echo "<td>".$soporte['titulo']."</td><td>".$soporte['precio']."</td><td>".$soporte['duracion']." minutos</td><td>";
                                        echo ($soporte['alquilado']) ? "No disponible":"Disponible";
                                        if($soporte['alquilado']) {
                                            echo "</td><td class='d-flex justify-content-end'><button disabled class='btn btn-success'>Alquilar</button></td>";
                                        } else {
                                            echo "</td><td class='d-flex justify-content-end'> <form method='post' action='../Logica/alquilar.php'> <input type='hidden' name='idSoporte' value='".$soporte['id']."'> <button type='submit' class='btn btn-success'>Alquilar</button> </form> </td>";
                                        }
                                        
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
            <div class="col-12 col-lg-12 d-flex justify-content-center">
                <a href="./pagina-principal-usuario.php"><button class="btn btn-outline-info">Volver Atrás</button></a>
            </div>
        </div>
    </div>
    
</body>
</html>