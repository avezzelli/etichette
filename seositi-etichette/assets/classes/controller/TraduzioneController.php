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
    
    public function salvaTraduzioni(array $lingue): bool{
        //il salvataggio delle traduzioni comporta la cancellazione di tutte quelle attive e
        //il successivo salvataggio di ogni traduzione nuova
        
        //trovo tutte le traduzioni per ottenere l'id
        $traduzioni = $this->getTraduzioni();
        //elimino le traduzioni
        if(ssf\checkResult($traduzioni)){
            foreach($traduzioni as $item){
                $trad = updateToTraduzione($item);
                $this->delete($trad->getID());
            }
        }
        
        //salvo le nuove traduzioni
        foreach($lingue as $item){
            $t = new Traduzione();
            $t->setLingua($item);
            if(!$this->save($t)){
                return false;
            }
        }
        
        return true;
    }
}
