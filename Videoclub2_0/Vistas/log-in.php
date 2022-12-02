<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS-->
    <link rel="stylesheet" href="../Estilos/Estilos.css">
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <!--JS Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Log-in</title>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-6"></div>

            <div class="col-12 col-lg-6 containForm d-flex flex-column justify-content-center align-items-center">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <h2 class="text-light">Login</h2>
                    </div>
                </div>

                <?php 
                    session_start();
                    if (isset($_SESSION['usuarioRegistrado'])) {
                        $existeUsuarioRegistrado = $_SESSION['usuarioRegistrado'];
                    }

                    if(isset($existeUsuarioRegistrado) && $existeUsuarioRegistrado) { ?>

                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="alert alert-success" role="alert">
                            El usuario ha sido registrado con éxito
                        </div>
                    </div>
                </div>

                <?php }

                    if (isset($_SESSION['errorCamposVacios'])) {
                        $existeErrorCamposVacios = $_SESSION['errorCamposVacios'];
                    }

                    if(isset($existeErrorCamposVacios) && $existeErrorCamposVacios) {?>
                        
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="alert alert-danger" id="alertaRegistro" role="alert">
                                    Por favor, rellena todos los campos.
                                </div>
                            </div>
                        </div>
                    
                <?php } 
                    if (isset($_SESSION['credencialesErroneas'])) {
                        $existeErrorCredenciales = $_SESSION['credencialesErroneas'];
                    }

                    if(isset($existeErrorCredenciales) && $existeErrorCredenciales) {?>
                                            
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="alert alert-danger" id="alertaRegistro" role="alert">
                                    Email o contraseña incorrectos.
                                </div>
                            </div>
                        </div>
                 <?php }?>       

                <div class="row">
                    <div class="col-12 col-lg-12 mt-3">
                        <form class="form" action="../Logica/log-inLogica.php" method="post">
                            <fieldset class=" ps-2">
                                <label class="text-light" for="email">Introduce tu correo:</label><br>
                                <input class="form-control" type="text" id="email" name="email" placeholder="ejemplo@ejemplo.com">
        
                                <label class="text-light mt-4" for="clave">Introduce tu contraseña:</label><br>
                                <input class="form-control" type="password" id="clave" name="clave" placeholder="Tu contraseña...">
        
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button class="btn btn-info " type="submit">Iniciar sesion</button>
                                    <a href="./registro.php">Registrarse</a>
                                </div>
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