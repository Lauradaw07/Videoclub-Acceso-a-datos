<?php
    namespace Dwes;

    require_once("resumible.php");

    use Dwes\Soporte;
    use Dwes\Resumible;

    abstract class Soporte implements Resumible {

        //Propiedades
        public string $titulo;
        public bool $alquilado;
        protected int $numero;
        private float $precio;
        private static $IVA = 0.21;

        public function __construct(int $numero, string $titulo,float $precio) {
            $this->titulo=$titulo;
            $this->numero = $numero;
            $this->precio=$precio;
            $this->alquilado = false;
        }

        //Metodos
        public function getPrecio(){
            return $this->precio;
        }

        public function getPrecioConIva() {
            return $this->precio + ($this->precio * self::$IVA);
        }

        public function getNumero() {
            return $this->numero;
        }

        public function getAlquilado() {
            return $this->alquilado;
        }

        public function muestraResumen():void {
            $estado = ($this->getAlquilado())? "Alquilado":"Sin alquilar";
            echo "<br>---------------------------------";
            echo "<br><b>PRODUCTO:</b>";
            echo "<br>---------------------------------";
            echo "<br><b>Nombre:</b> ".$this->titulo;
            echo "<br><b>Precio:</b> ".$this->precio."€";
            echo "<br><b>Precio con IVA:</b> " . round($this->getPrecioConIva(), 2)."€";
            echo "<br><b>Estado:</b> ". $estado;
        }
    }

?>