<?php

namespace etichette;
use seositiframework as ssf;

class Traduzione extends ssf\MyObject {

    private string $lingua;
    
    function __construct() {
        parent::__construct();
        $this->lingua = '';
    }
    
    public function getLingua(): string {
        return $this->lingua;
    }

    public function setLingua(string $lingua): void {
        $this->lingua = $lingua;
    }


}
