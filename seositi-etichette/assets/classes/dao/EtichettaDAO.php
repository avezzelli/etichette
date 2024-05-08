<?php

namespace etichette;
use seositiframework as ssf;

class EtichettaDAO extends ssf\ObjectDAO implements ssf\InterfaceDAO {

    function __construct() {
        parent::__construct(DBT_ETI);
    }

    public function deleteByID($ID): bool {
        return parent::deleteObjectByID($ID);
    }

    public function exists(\seositiframework\MyObject $o): bool {
        $obj = $this->updateToObj($o);
        //il campo discriminante è l'url
        $where = array();
        if($obj->getUrl() != '' && $obj->getUrl() != null){
            array_push($where, ssf\getQueryField(DBT_ETI_URL, $obj->getUrl(), 'TEXT'));
        }
        $resQuery = parent::getObjectsDAO($where);
        if(ssf\checkResult($resQuery)){
            return true;
        }
        return false;
    }

    public function getArray(\seositiframework\MyObject $o): array {
        $obj = $this->updateToObj($o);
        return array(
            DBT_NOME        => $obj->getNome(),
            DBT_ETI_DATA    => $obj->getDataInserimento(),
            DBT_ETI_URL     => $obj->getUrl(),
            DBT_ID_CLI      => $obj->getIdCliente(),            
            DBT_ID_CAT      => $obj->getIdCategoria(),
            DBT_ETI_LINK    => $obj->getLink(),
            DBT_ETI_IMG     => $obj->getImmagine()
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
        return array('%s', '%s', '%s', '%d', '%d', '%s', '%s');
    }

    public function getObj($item): Etichetta {
        $obj = $this->newObj();
        $obj->setID($item[DBT_ID]);
        $obj->setNome($item[DBT_NOME]);
        $obj->setDataInserimento($item[DBT_ETI_DATA]);
        $obj->setUrl($item[DBT_ETI_URL]);
        $obj->setIdCliente($item[DBT_ID_CLI]);        
        $obj->setIdCategoria($item[DBT_ID_CAT]);
        $obj->setLink($item[DBT_ETI_LINK]);
        $obj->setImmagine($item[DBT_ETI_IMG]);
        return $obj;
    }

    public function getResults($where = null, $order = null): array|null {
        return $this->getArrayResult(parent::getObjectsDAO($where, $order));
    }

    public function newObj(): Etichetta {
        return new Etichetta();
    }

    public function save(\seositiframework\MyObject $o): bool|int {
        $obj = $this->updateToObj($o);       
        if(!$this->exists($obj)){
            return parent::saveObject($this->getArray($obj), $this->getFomato());
        }
        return -1;
    }

    public function search($query): array|null {
        return $this->getArrayResult(parent::searchObjects($query));
    }

    public function update(\seositiframework\MyObject $o): int|bool|null {
        $obj = $this->updateToObj($o);
        return parent::updateObject($this->getArray($o), $this->getFomato(), array(DBT_ID => $obj->getID()), array('%d'));     
    }

    public function updateToObj(\seositiframework\MyObject $o): Etichetta {
        return updateToEtichetta($o);
    }
    
    public function getResultByID($ID): Etichetta|null {
        $temp = parent::getResultByID($ID);        
        if($temp != null){
            return $this->getObj($temp);
        }
        return null;
    }

}
