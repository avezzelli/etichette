<?php

namespace etichette;
use seositiframework as ssf;

class Categoria extends ssf\MyObject {
    
    private string $nome;

    function __construct() {
        parent::__construct();
        $this->nome = '';
    }
    
    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }



}
