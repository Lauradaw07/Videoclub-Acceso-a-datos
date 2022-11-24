<?php
    require_once "./Dwes/videoclub.php";
    require_once "./Dwes/Soporte.php";
    require_once "./Dwes/CintaVideo.php";
    require_once "./Dwes/Juego.php";
    require_once "./Dwes/Dvd.php";
    require_once "./Dwes/cliente.php";

    use Dwes\VideoClub;
    use Dwes\Soporte;
    use Dwes\Juego;
    use Dwes\CintaVideo;
    use Dwes\Dvd;
    use Dwes\cliente;

    $videoClub = new VideoClub("VideoCLub Array");
    //2, "Origen", 15, "es, en, fr", "16:9
    //3, "The Last Of Us II", 49.99, "PS4", 2, 7
    //4, "The Ladasst Of Us II", 49.99, "PS4", 2, 7
    //1000, "Juan", 2

    $videoClub->incluirCinta(1, "Los cazafantasmas", 3.5, 107);
    $videoClub->incluirDvd(2, "Origen", 15, "es, en, fr", "16:9");
    $videoClub->incluirJuego(3, "The Last Of Us II", 49.99, "PS4", 2, 7);
    $videoClub->incluirJuego(4, "The Last Of Us I Remake", 79.99, "PS5", 1, 1);
    $videoClub->incluirJuego(8, "Undertale", 1, "Ordenador", 1, 1);
    $videoClub->incluirDvd(5, "Titanic", 15, "es, en, fr", "16:9");
    $videoClub->incluirCinta(6, "Hulk", 3.5, 107);
    $videoClub->incluirDvd(7, "SpiderMan", 15, "es, en, fr", "16:9");
    

    $videoClub->incluirSocio(1000, "Juan", 5);
    // $videoClub->incluirSocio(1001, "Laura", 3);

    // $videoClub->listarSocios();

    $videoClub->alquilarSocioProductos(1000, [1,2,3,4,5]);

    $cliente = $videoClub->obtenerSocio(1000);

    $videoClub->devolverSocioProductos(1000, [1,10]);

    // $cliente->listarAlquileres();

    $cliente->listarAlquileres();

    // $videoClub->devolverSocioProductos(1001, [1,2]);
    
?>
