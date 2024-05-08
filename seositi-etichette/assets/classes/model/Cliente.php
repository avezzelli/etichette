<?php

namespace etichette;
use seositiframework as ssf;

class Cliente extends ssf\MyObject {
    
    private string $nome;
    private int $idWP;    

    function __construct() {
        parent::__construct();
        $this->nome = '';
        $this->idWP = 0;           
    }
    
    public function getNome(): string {
        return $this->nome;
    }

    public function getIdWP(): int {
        return $this->idWP;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function setIdWP(int $idWP): void {
        $this->idWP = $idWP;
    }
    
    





}
