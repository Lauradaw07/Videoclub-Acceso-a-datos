<?php
namespace Dwes;

require_once "Util/SoporteYaAlquiladoException.php";
use Dwes\Util\SoporteYaAlquiladoException;

    class Cliente {
        //Atributos
        private string $nombre;
        private array $soportesAlquilados;
        private int $numSoportesAlquilados;
        private int $maxAlquilerConcurrente;

        //Constructor
        public function __construct(int $numero, string $nombre, int $maxAlquilerConcurrente = 3) {
            $this->nombre = $nombre;
            $this->numero = $numero;
            $this->soportesAlquilados = [];
            $this->numSoportesAlquilados = 0;
            $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
        }

        //Getters y setters
        public function getNumero() {
            return $this->numero;
        }

        public function getNumSoportesAlquilados() {
            return $this->numSoportesAlquilados;
        }

        public function getMaxAlquilerConcurrente() {
            return $this->maxAlquilerConcurrente;
        }
        
        public function getSoportesAlquilados(){
            return $this->soportesAlquilados;
        }

        public function setNumero($numero) {
            $this->numero = $numero;
        }

        //Métodos
        
        public function alquilar($soporte) {
            try{
                if($this->tieneAlquilado($soporte) == false) {

                    if(count($this->soportesAlquilados) <= $this->maxAlquilerConcurrente) {
                        array_push($this->soportesAlquilados, $soporte);
                        $this->numSoportesAlquilados++;
                        $soporte->alquilado = true;
                        return true;
                    }
                } else throw new SoporteYaAlquiladoException;
            } catch (SoporteYaAlquiladoException $e){
                echo $e->escribirError();
                return false;
            }
            
        }

        public function tieneAlquilado($soporte) {
            foreach($this->soportesAlquilados as $soporteAlquilado) {
                if($soporteAlquilado->getNumero() == $soporte->getNumero()) {
                    return true;
                }
            }
            return false;
        }

        public function devolver($numeroSoporte) {
            for($i = 0; $i < count($this->soportesAlquilados); $i++) {
                if($this->soportesAlquilados[$i]->getNumero() == $numeroSoporte) {
                    array_splice($this->soportesAlquilados, $i, 1);
                    return true;
                }
            }
            return false;
        }

        public function listarAlquileres() {
            echo "<br><br><b>Número de alquileres:</b> ". count($this->soportesAlquilados);
            echo "<br><b>Alquileres:</b><br>";
            foreach($this->soportesAlquilados as $soporteAlquilado) {
                echo $soporteAlquilado->mostrarResumen()."<br>";
            }
        }
    }
?>