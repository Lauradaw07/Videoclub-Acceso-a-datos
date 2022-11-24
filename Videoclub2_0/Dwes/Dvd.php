<?php
namespace Dwes;
class Dvd extends Soporte
{
    //Propiedades
    public string $idiomas;
    private string $formatPantalla;

    //Constructor
    public function __construct(int $num, string $titulo, float $precio, string $idiomas, string $formatPantalla)
    {
        parent::__construct($num, $titulo, $precio);
        $this->idiomas=$idiomas;
        $this->formatPantalla=$formatPantalla;
    }

    //Metodos
    public function mostrarResumen() {
        parent::muestraResumen();
        echo "<br><b>Tipo:</b>Película en DVD:<br>".
        $this->titulo."<br>".
        $this->getPrecio()." € (IVA no incluido)<br>".
        "Idiomas: ".$this->idiomas."<br>".
        "Formato Pantalla :".$this->formatPantalla;
    }
}
?>