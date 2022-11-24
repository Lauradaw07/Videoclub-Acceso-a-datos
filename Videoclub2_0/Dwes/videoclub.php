<?php
    namespace Dwes;
    include_once("Soporte.php");
    include_once("Cliente.php");

    require_once "Util/CupoSuperadoException.php";
    require_once "Util/ClienteNoEncontradoException.php";
    require_once "Util/SoporteNoEncontradoException.php";
    
    use Dwes\Util\CupoSuperadoException;
    use Dwes\Util\ClienteNoEncontradoException;
    use Dwes\Util\SoporteNoEncontradoException;

    class VideoClub {

        public function __construct
        (
            private string $nombre,
            private array $productos = [],
            private int $numProductos = 0,
            private array $socios = [],
            private int $numSocios = 0,
            private int $numProductosAlquilados = 0,
            private int $numTotalAlquileres = 0,

        ){}

        //Getters
        public function getNumProductosAlquilados()
        {
            return $this->numProductosAlquilados;
        }
        
        public function getNumTotalAlquileres() {
            return $this->NumTotalAlquileres;
        }

        //Métodos
        private function incluirProducto($producto){
            array_push($this->productos, $producto);
            $this->numProductos++;
        }

        public function incluirCinta($num, $titulo, $precio, $duracion){
            $this->incluirProducto(new CintaVideo($num, $titulo, $precio, $duracion));
        }

        public function incluirDvd($num, $titulo, $precio, $idiomas, $pantalla){
            $this->incluirProducto(new Dvd($num, $titulo, $precio, $idiomas, $pantalla));
        }

        public function incluirJuego($num, $titulo, $precio, $consola, $minJ, $maxJ){
            $this->incluirProducto(new Juego($num, $titulo, $precio, $consola, $minJ, $maxJ));
        }

        public function incluirSocio($num, $nombre, $maxAlquileresConcurrentes = 3){
            array_push($this->socios, new Cliente($num, $nombre, $maxAlquileresConcurrentes));
            $this->numSocios++;
        }

        public function listarProductos() {
            echo "PRODUCTOS DISPONIBLES: " . $this->numProductos . "<br>";
            for ($x = 0; $x < count($this->productos); $x++) {
                echo "<br><br>-" . $this->productos[$x]->mostrarResumen() . "<br>";
            }
        }

        public function listarSocios(){
            echo "CLIENTES: " . $this->numSocios;
            for($x = 0; $x < count($this->socios); $x++){
                echo "<br>-ID: " . $this->socios[$x]->getNumero() . "Soportes Alquilados: " . $this->socios[$x]->listarAlquileres();
            }
        }

        public function obtenerSocio($numSocio) {
            foreach($this->socios as $socio) {
                if($socio->getNumero() == $numSocio) return $socio;
            }
        }

        public function alquilarSocioProducto($numeroCliente, $numSoporte){
            for($i = 0; $i < count($this->socios); $i++) {
                if($this->socios[$i]->getNumero() == $numeroCliente) { //
                    for($j = 0; $j < count($this->productos); $j++) {
                        if($this->productos[$j]->getNumero() == $numSoporte) {
                            $this->socios[$i]->alquilar($this->productos[$j]);
                        }
                    }
                }
            }
        }
          

        public function alquilarSocioProductos($numSocio, $numSoportes) {
            try{
                //Comprobamos que el socio esté en el array de socios
                if($this->obtenerSocio($numSocio) == null){
                    throw new ClienteNoEncontradoException;
                } else $cliente = $this->obtenerSocio($numSocio);
            } catch (ClienteNoEncontradoException $e) {
                echo $e->escribirError();
                return false;
            }

            //Comprobamos cuántos alquileres le quedan al socio
            $alquileresRestantes =  ($cliente->getMaxAlquilerConcurrente()) - (count($cliente->getSoportesAlquilados()));

            try{
                if(count($numSoportes) <= $alquileresRestantes) {
                    $contador = 0;
                    $contadorSoportesEncontrados = 0;
                    $todosProductosEncontrados = true;
                    foreach($this->productos as $producto){
                        foreach($numSoportes as $numero){
                                //Comprobamos que el producto esté en el array de productos del videoclub
                                
                                if($producto->getNumero() == $numero) {
                                    $contadorSoportesEncontrados++;
                                    if($producto->getAlquilado() == false){
                                        $contador++;
                                    }

                                } 
                        }
                    }

                    try{
                        if($contadorSoportesEncontrados == count($numSoportes)) {
                            if($contador == count($numSoportes)){
                                foreach($numSoportes as $numero) {
                                    $this->alquilarSocioProducto($numSocio, $numero);
                                }    
                            }
                        } else throw new SoporteNoEncontradoException;
                    }catch (SoporteNoEncontradoException $e){
                        echo $e->escribirError();
                        return false;
                    }
                    
                } else throw new CupoSuperadoException;
            } catch (CupoSuperadoException $e) {
                echo $e->escribirError();
                return false;
            }
        
        }

        public function devolverSocioProducto($numSocio, $numeroProducto) {
            for($i = 0; $i < count($this->socios); $i++) {
                if($this->socios[$i]->getNumero() == $numSocio) {
                    // $cliente = $this->obtenerSocio($numeroCliente);
                    // if($cliente)
                    for($j = 0; $j < count($this->productos); $j++) {
                        if($this->productos[$j]->getNumero() == $numeroProducto) {
                            if($this->socios[$i]->devolver($this->productos[$j]->getNumero())) {
                                $this->productos[$j]->alquilado = false;
                            }
                        }
                    }
                }
            }
        }

        public function devolverSocioProductos($numSocio, $numProductos) {
            try{
                //Comprobamos que el socio esté en el array de socios
                if($this->obtenerSocio($numSocio) == null) {
                    throw new ClienteNoEncontradoException;
                } else $cliente = $this->obtenerSocio($numSocio);
            } catch (ClienteNoEncontradoException $e) {
                echo $e->escribirError();
                return false;
            }
            
            $contadorSoportesEncontrados = 0;
            for($i = 0; $i < count($this->socios); $i++) {
                if($this->socios[$i]->getNumero() == $numSocio) { //AQUÍ CLIENTE NO ENCONTRADO
                    for($j = 0; $j < count($numProductos); $j++) {
                        foreach($cliente->getSoportesAlquilados() as $soporteAlquilado) {
                        
                            if($numProductos[$j] == $soporteAlquilado->getNumero()){ //AQUI SOPORTE NO ENCONTRADO
                                $contadorSoportesEncontrados++;
                                $this->devolverSocioProducto($numSocio, $numProductos[$j]);
                            } 
                        
                            
                        }
                    }
                }
            }

            try {
                if($contadorSoportesEncontrados == count($numProductos)) {
                   
                } else throw new SoporteNoEncontradoException;
            } catch (SoporteNoEncontradoException $e) {
                echo $e->escribirError();
                return false;
            }
            
        }
    }

?>