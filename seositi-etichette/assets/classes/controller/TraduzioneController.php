<?php

namespace etichette;
use seositiframework as ssf;

class TraduzioneController implements ssf\InterfaceController{

    private TraduzioneDAO $traDAO;   
    private VoceTradottaDAO $vtrDAO;
    
    private array $lingue = array(
            'en' => 'English',
            'fr' => 'Français',
            'de' => 'Deutsch',
            'es' => 'Español'
        );
    
    function __construct() {
        $this->traDAO = new TraduzioneDAO();     
        $this->vtrDAO = new VoceTradottaDAO();
    }
    
    public function getLingue():array{
        return $this->lingue;
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
    
    /**
     * La funzione restituisce un array di lingue attive per la traduzione;
     * @return array
     */
    public function getLingueAttive(): array{
        $result = array();
        $temp = $this->traDAO->getResults();
        if(ssf\checkResult($temp)){
            foreach($temp as $item){
                $t = updateToTraduzione($item);
                array_push($result, $t->getLingua());
            }
        }        
        return $result;
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
    
    
    /**** VOCI TRADOTTE *****/
    
    /**
     * La funzione controlla se esiste una voce tradotta in riferimento ad una voce del template 
     * in riferimento ad una lingua passata. 
     * @param int $idVoce
     * @param string $lang
     * @return bool
     */
    public function checkVoceTradotta(int $idVoce, string $lang): bool{
        $where = array(
            ssf\getQueryField(DBT_ID_VOC, $idVoce, ssf\Formato::NUMERO()),
            ssf\getQueryField(DBT_VTR_LANG, $lang, ssf\Formato::TESTO())
        );        
        $temp = $this->vtrDAO->getResults($where);
        
        if(ssf\checkResult($temp)){
            return true;
        }
        return false;
    }
    
    public function getVociTradotte(int $idTemplate): array {
        $result = array();
        $where = array(
            ssf\getQueryField(DBT_ID_TEM, $idTemplate, ssf\Formato::NUMERO())
        );
        $temp = $this->vtrDAO->getResults($where);
        if(ssf\checkResult($temp)){
            foreach($temp as $item){               
                array_push($result, updateToVoceTradotta($item));
            }
        }        
        return $result;
    }
    
    public function getVoceTradotta(int $idVT): null|VoceTradotta{
        return $this->vtrDAO->getResultByID($idVT);
    }
    
    public function saveVoceTradotta(VoceTradotta $vt): bool{
        if($this->vtrDAO->save($vt) > 0){
            return true;
        }
        return false;
    }
    
    public function updateVoceTradotta(VoceTradotta $vt): bool|int{
        return $this->vtrDAO->update($vt);
    }
    
    public function deleteVociTradotteByTemplate(int $idTem):bool{
        $where = array(DBT_ID_TEM => $idTem);
        return $this->vtrDAO->delete($where);
    }
}
