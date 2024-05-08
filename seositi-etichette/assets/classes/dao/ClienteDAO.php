<?php

namespace etichette;
use seositiframework as ssf;

class ClienteDAO extends ssf\ObjectDAO implements ssf\InterfaceDAO {

    function __construct() {
        parent::__construct(DBT_CLI);
    }

    public function deleteByID($ID): bool {
        return parent::deleteObjectByID($ID);
    }

    public function exists(ssf\MyObject $o): bool {
        $obj = $this->updateToObj($o);
        //il campo discriminante è il nome
        $where = array();
        if($obj->getNome() != '' && $obj->getNome() != null){
            array_push($where, ssf\getQueryField(DBT_NOME, $obj->getNome(), ssf\Campo::TESTO()));
        }
        $resQuery = parent::getObjectsDAO($where);
        if(ssf\checkResult($resQuery)){
            return true;
        }
        return false;
    }

    public function getArray(ssf\MyObject $o): array {
        $obj = $this->updateToObj($o);
        return array(
            DBT_NOME    => $obj->getNome(),
            DBT_ID_WP   => $obj->getIdWP()
        );
    }

    public function getArrayResult(array $resultQuery): array|null {
        if(ssf\checkResult($resultQuery)){
           $result = array();
           foreach($resultQuery as $item){
               array_push($result, $this->getObj($item));
           }
           return $result;
        }
        return null;
    }

    public function getFomato(): array {
        return array('%s', '%d');
    }

    public function getObj($item): Cliente {
        $obj = $this->newObj();
        $obj->setID($item[DBT_ID]);
        $obj->setNome($item[DBT_NOME]);
        $obj->setIdWP($item[DBT_ID_WP]);
        return $obj;
    }

    public function getResults($where = null, $order = null): array|null {
        return $this->getArrayResult(parent::getObjectsDAO($where, $order));
    }

    public function newObj(): Cliente {
        return new Cliente();
    }

    public function save(ssf\MyObject $o): bool|int {
        $obj = $this->updateToObj($o);       
        if(!$this->exists($obj)){               
            return parent::saveObject($this->getArray($obj), $this->getFomato());
        }       
        return -1;
    }

    public function search($query): array|null {
        return $this->getArrayResult(parent::searchObjects($query));
    }

    public function update(ssf\MyObject $o): int|bool|null {
        $obj = $this->updateToObj($o);
        return parent::updateObject($this->getArray($o), $this->getFomato(), array(DBT_ID => $obj->getID()), array('%d'));     
    }

    public function updateToObj(ssf\MyObject $o): Cliente {
        return updateToCliente($o);
    }
    
    public function getResultByID($ID): Cliente|null {
        $temp = parent::getResultByID($ID);        
        if($temp != null){
            return $this->getObj($temp);
        }
        return null;
    }

}
