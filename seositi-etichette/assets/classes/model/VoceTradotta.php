<?php

namespace etichette;
use seositiframework as ssf;

class VoceTradotta extends ssf\MyObject {
    
    private int $idVoce;
    private string $lang;
    private int $idTemplate;
    private string $label;
    private string $valore;
    private string $tipo;
    private int $visualizza;
    
        
    function __construct() {
        parent::__construct();        
        $this->idVoce = 0;
        $this->lang = ''; 
        $this->idTemplate = 0;
        $this->label = '';
        $this->valore = '';
        $this->tipo = '';
        $this->visualizza = 0;        
    }
    
    public function getIdVoce(): int {
        return $this->idVoce;
    }

    public function getLang(): string {
        return $this->lang;
    }

    public function getIdTemplate(): int {
        return $this->idTemplate;
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

    public function getVisualizza(): int {
        return $this->visualizza;
    }

    public function setIdVoce(int $idVoce): void {
        $this->idVoce = $idVoce;
    }

    public function setLang(string $lang): void {
        $this->lang = $lang;
    }

    public function setIdTemplate(int $idTemplate): void {
        $this->idTemplate = $idTemplate;
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

    public function setVisualizza(int $visualizza): void {
        $this->visualizza = $visualizza;
    }

}
