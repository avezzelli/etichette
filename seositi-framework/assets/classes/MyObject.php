<?php

namespace seositiframework;

/**
 * MyObecjt è la classe base model di SeoSiti Framework.
 * Viene definito il costruttore e solamente l'ID
 *
 * @author SeoSiti Developing Team
 */
class MyObject {
   
    private int $ID;

    function __construct() {
        $this->ID = 0;
    }
    
    public function getID(): int {
        return $this->ID;
    }

    public function setID(int $ID): void {
        $this->ID = $ID;
    }
   
}
