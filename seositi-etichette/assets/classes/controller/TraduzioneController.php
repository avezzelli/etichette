<?php

namespace etichette;
use seositiframework as ssf;

class TraduzioneController implements ssf\InterfaceController{

    private TraduzioneDAO $traDAO;
    
    function __construct() {
        $this->traDAO = new TraduzioneDAO();
    }

    public function delete(int $ID): bool {
        return $this->traDAO->deleteByID($ID);
    }

    public function get(int $ID): Traduzione|null {
        return $this->traDAO->getResultByID($ID);
    }

    public function save(ssf\MyObject $o): bool {
        $obj = updateToTraduzione($o);
        if($this->traDAO->save($obj) > 0){
            return true;
        }
        return false;
    }

    public function update(ssf\MyObject $o): bool|int {
        $obj = updateToTraduzione($o);
        return $this->traDAO->update($obj);
    }
    
    public function getTraduzioni(): array|null{
        return $this->traDAO->getResults();
    }
}
