<?php
namespace etichette;
use \seositiframework as ssf;
class Template extends ssf\MyObject{

    private string $nome;
    private int $tipo;
    private array $voci;
    private int $idEtichetta;
    private array $vociTradotte;
    
    function __construct() {
        parent::__construct();
        $this->nome = '';
        $this->tipo = 0;
        $this->idEtichetta = 0;
        $this->vociTradotte = array();
    }
    
    public function getNome(): string {
        return $this->nome;
    }

    public function getTipo(): int {
        return $this->tipo;
    }

    public function getVoci(): array {
        return $this->voci;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function setTipo(int $tipo): void {
        $this->tipo = $tipo;
    }

    public function setVoci(array $voci): void {
        $this->voci = $voci;
    }

    public function getIdEtichetta(): int {
        return $this->idEtichetta;
    }

    public function setIdEtichetta(int $idEtichetta): void {
        $this->idEtichetta = $idEtichetta;
    }
    
    public function getVociTradotte(): array {
        return $this->vociTradotte;
    }

    public function setVociTradotte(array $vociTradotte): void {
        $this->vociTradotte = $vociTradotte;
    }

}
