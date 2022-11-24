<?php
namespace Dwes;
class Juego extends Soporte
{
    //Propiedades
    public string $consola;
    private int $minNumJugadores;
    private int $maxNumJugadores;

    //Constructor
    public function __construct(int $num, string $titulo,float $precio, string $consola, int $minNumJugadores, int $maxNumJugadores)
    {
        parent::__construct($num, $titulo, $precio);
        $this->consola=$consola;
        $this->minNumJugadores=$minNumJugadores;
        $this->maxNumJugadores=$maxNumJugadores;
    }

    //Métodos
    public function muestaJugadoresPosibles()
    {
        if ($this->minNumJugadores == 1 && $this->maxNumJugadores == 1) {
            return "Para un jugador";
        }
        if ($this->minNumJugadores >= 1 && $this->maxNumJugadores > 1) {
            return "De ".$this->minNumJugadores." a ".$this->maxNumJugadores." jugadores";
        }
    }

    public function mostrarResumen() {
        
        echo parent::muestraResumen()."<br>Juego para: ".$this->consola."<br>".
        $this->titulo."<br>".
        $this->getPrecio()." € (IVA no incluido)<br>".
        $this->muestaJugadoresPosibles();
    }



    






}
?>