<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS-->
    <link rel="stylesheet" href="../Estilos/Estilos.css">
    <!--CSS Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <!--JS Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Registro</title>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-6"></div>

            <div class="col-12 col-lg-6 containForm d-flex flex-column justify-content-center align-items-center">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <h2 class="text-light">Registro</h2>
                    </div>
                </div>
                <?php
                    
                    session_start();
                    var_dump($_SESSION);
                    if (isset($_SESSION['errorClaveDistinta'])) {
                        $existeErrorClaveDistinta = $_SESSION['errorClaveDistinta'];
                    }

                    if(isset($existeErrorClaveDistinta) && $existeErrorClaveDistinta) {?>
                       
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="alert alert-danger" id="alertaRegistro" role="alert">
                                Las contraseñas introducidas no coinciden.
                            </div>
                        </div>
                    </div>
                <?php }
                    if (isset($_SESSION['errorEmailYaRegistrado'])) {
                        $existeErrorEmailRegistrado = $_SESSION['errorEmailYaRegistrado'];
                    }

                    if(isset($existeErrorEmailRegistrado) && $existeErrorEmailRegistrado) {?>

                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="alert alert-danger" id="alertaRegistro" role="alert">
                                    El email indicado ya está registrado
                                </div>
                            </div>
                        </div>
                <?php }?>
                
                <!-- <script>
                    
                    // const idTimeout = setTimeout(() => { 
                    //     alertaRegistro.classList.add('ocultar'); <?=session_destroy();?>}, 5000);
                       
                </script> -->
                    
                <div class="row">
                    <div class="col-12 col-lg-12 col-sm-8 mt-3">
                        <form class="form" action="../Logica/registroLogica.php" method="post">
                            <fieldset class="p-2">
                                <label  for="nombre">Introduce tu nombre:</label><br>
                                <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre...">

                                <label  class="mt-2" for="usuario">Introduce tu nombre de usuario:</label><br>
                                <input class="form-control" type="text" name="usuario" id="usuario" placeholder="Bravo">

                                <label class="mt-2" for="email">Introduce tu email</label><br>
                                <input class="form-control" type="email" name="email" id="email" placeholder="ejemplo@ejemplo.com">

                                <label class="mt-2" for="clave">Introduce tu clave:</label><br>
                                <input class="form-control" type="password" name="clave" id="clave" placeholder="Contraseña...">

                                <label class="mt-2" for="comprobacionClave">Introduce de nuevo tu clave:</label><br>
                                <input class="form-control" type="password" name="comprobacionClave" id="comprobacionClave" placeholder="Contraseña..."><br>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                <button class="btn btn-info" id="" type="submit">Registrarme</button>
                                <button class="btn btn-danger" type="reset">Borrar</button>
                                </div>
                                <a href="./log-in.html"><p class="text-center mt-3">Iniciar Sesión</p></a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/loging-registro.js"></script>

</body>
</html>