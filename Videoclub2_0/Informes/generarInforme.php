<?php 
    $nombreUsuario = $_POST['usuario'];
    $idCliente= $_POST['idCliente'];

    $archivo = "informe-". $nombreUsuario ."-". date('d-m-Y') .".txt";

    include "../Logica/database.inc.php";

    $conexion = new PDO(DSN, USUARIO, CLAVE);
    $conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM soporte INNER JOIN alquileres on (soporte.id = alquileres.idSoporte) AND (alquileres.idCliente = ?)';
    $sentencia = $conexion->prepare($sql);

    $sentencia ->setFetchMode(PDO::FETCH_NUM);
    $sentencia -> execute([$idCliente]);

    $alquileres = $sentencia->fetchAll();
  

    if(isset($alquileres)){
        $fp = fopen($archivo, "w");
        foreach($alquileres as $alquiler) {
            $fila = "Nombre: ".$alquiler[1]." | Precio: ".$alquiler[2]." | Fecha Alquiler: ".$alquiler[5]."\n";
            fwrite($fp,$fila);
            // fwrite($archivo,"\n");
        }

        fclose($fp);

        header('Location: ../Vistas/pagina-principal-usuario.php');
    }

    

    
?>