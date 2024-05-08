<?php

namespace etichette;
use seositiframework as ssf;

class Voce extends ssf\MyObject {
    
    private string $label;
    private string $valore;
    private string $tipo;
    private int $idTemplate;
    private int $visualizza;

    function __construct() {
        parent::__construct();
        $this->label = '';
        $this->valore = '';
        $this->tipo = 0;
        $this->idTemplate = 0;
        $this->visualizza = 0;
    }
    
    public function getLabel(): string {
        return $this->label;
    }

    public function getValore(): string {
        return $this->valore;
    }

    public function getTipo(): string {
        return $this->tipo;
    }

    public function getIdTemplate(): int {
        return $this->idTemplate;
    }

    public function setLabel(string $label): void {
        $this->label = $label;
    }

    public function setValore(string $valore): void {
        $this->valore = $valore;
    }

    public function setTipo(string $tipo): void {
        $this->tipo = $tipo;
    }

    public function setIdTemplate(int $idTemplate): void {
        $this->idTemplate = $idTemplate;
    }

    public function getVisualizza(): int {
        return $this->visualizza;
    }

    public function setVisualizza(int $visualizza): void {
        $this->visualizza = $visualizza;
    }

}
