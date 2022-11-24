<?php
namespace Dwes;
class CintaVideo extends Soporte
{
    //Propiedades
    private int $duracion;

    //Constructor
    public function __construct(int $num, string $titulo, float $precio, int $duracion){
        parent::__construct($num, $titulo, $precio);
        $this->duracion=$duracion ;
    }

    //Metodos
    public function mostrarResumen() {
        parent::muestraResumen();
        echo "<br><b>Tipo:</b>Película en VHS<br>".
        $this->titulo."<br>".
        $this->getPrecio()." € (IVA no incluido)<br>".
        "Duracion: ".$this->duracion." minutos";
    }
}
?>