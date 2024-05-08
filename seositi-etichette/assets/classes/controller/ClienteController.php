<?php

namespace etichette;
use seositiframework as ssf;

class ClienteController implements ssf\InterfaceController {
    
    private ClienteDAO $cliDAO;

    function __construct() {
        $this->cliDAO = new ClienteDAO();
    }

    public function delete(int $ID): bool {
        return $this->cliDAO->deleteByID($ID);
    }

    public function get(int $ID): Cliente|null {
        return $this->cliDAO->getResultByID($ID);
    }

    public function save(ssf\MyObject $o): bool {  
        $obj = updateToCliente($o);
        if($this->cliDAO->save($obj) > 0){            
            return true;
        }       
        return false;
    }

    public function update(ssf\MyObject $o):bool|int {
        $obj = updateToCliente($o);
        return $this->cliDAO->update($obj);
    }
    
    public function getClienti(): array | null{
        return $this->cliDAO->getResults();
    }
    
    /**
     * Restituisce un array di clienti utilizzabili nel form etichette
     * @return array
     */
    public function getClientiForm(): array{
        $result = array();
        $clienti = $this->getClienti();
        if(ssf\checkResult($clienti)){
            foreach($clienti as $item){
                $cliente = updateToCliente($item);
                $result[$cliente->getID()] = $cliente->getNome();
            }
        }        
        return $result;
    }
}
