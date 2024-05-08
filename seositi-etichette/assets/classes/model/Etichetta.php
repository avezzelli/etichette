<?php

namespace etichette;
use seositiframework as ssf;

class Etichetta extends ssf\MyObject{

    private string $nome;
    private string $dataInserimento;
    private string $url;
    private int $idCategoria;
    private int $idCliente;
    private ?Template $template;
    private string $link;
    private int $idModelloTemplate;
    private string $immagine;
    
    
    function __construct() {
        parent::__construct();
        $this->nome = '';
        $this->dataInserimento = '';
        $this->url = '';
        $this->idCategoria = 0;
        $this->idCliente = 0;
        $this->template = null;
        $this->link = '';
        $this->idModelloTemplate=0;
        $this->immagine = '';
    }
    
    public function getNome(): string {
        return $this->nome;
    }

    public function getDataInserimento(): string {
        return $this->dataInserimento;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getIdCategoria(): int {
        return $this->idCategoria;
    }

    public function getIdCliente(): int {
        return $this->idCliente;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function setDataInserimento(string $dataInserimento): void {
        $this->dataInserimento = $dataInserimento;
    }

    public function setUrl(string $url): void {
        $this->url = $url;
    }

    public function setIdCategoria(int $idCategoria): void {
        $this->idCategoria = $idCategoria;
    }

    public function setIdCliente(int $idCliente): void {
        $this->idCliente = $idCliente;
    }

    public function getTemplate(): Template|null {
        return $this->template;
    }

    public function setTemplate(Template|null $template): void {
        $this->template = $template;
    }

    public function getLink(): string {
        return $this->link;
    }

    public function setLink(string $link): void {
        $this->link = $link;
    }

    public function getIdModelloTemplate(): int {
        return $this->idModelloTemplate;
    }

    public function setIdModelloTemplate(int $idModelloTemplate): void {
        $this->idModelloTemplate = $idModelloTemplate;
    }
    
    public function getImmagine(): string|null {
        return $this->immagine;
    }

    public function setImmagine(string|null $immagine): void {
        $this->immagine = $immagine;
    }

}
