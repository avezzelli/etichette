<?php

namespace etichette;
use seositiframework as ssf;

class VoceDAO extends ssf\ObjectDAO implements ssf\InterfaceDAO {

    function __construct() {
        parent::__construct(DBT_VOC);
    }

    public function deleteByID($ID): bool {
        return parent::deleteObjectByID($ID);
    }
    
    public function delete(array $where):bool{
        return parent::deleteObject($where);
    }

    public function exists(ssf\MyObject $o): bool {
       //non serve
    }

    public function getArray(ssf\MyObject $o): array {
        $obj = updateToVoce($o);
        return array(
            DBT_VOC_LBL     => $obj->getLabel(),
            DBT_VOC_VALORE  => $obj->getValore(),
            DBT_VOC_TIPO    => $obj->getTipo(),
            DBT_ID_TEM      => $obj->getIdTemplate(),
            DBT_VOC_VIS     => $obj->getVisualizza()                
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
        return array('%s', '%s', '%s', '%d', '%d');
    }

    public function getObj($item): Voce {
        $obj = $this->newObj();
        $obj->setID($item[DBT_ID]);
        $obj->setLabel($item[DBT_VOC_LBL]);
        $obj->setValore($item[DBT_VOC_VALORE]);
        $obj->setTipo($item[DBT_VOC_TIPO]);
        $obj->setIdTemplate($item[DBT_ID_TEM]);
        $obj->setVisualizza($item[DBT_VOC_VIS]);
        return $obj;
    }

    public function getResults($where = null, $order = null): array|null {
        return $this->getArrayResult(parent::getObjectsDAO($where, $order));
    }

    public function newObj() {
        return new Voce();
    }

    public function save(ssf\MyObject $o): bool|int {
        $obj = $this->updateToObj($o);        
        return parent::saveObject($this->getArray($obj), $this->getFomato());
    }

    public function search($query): array|null {
        return $this->getArrayResult(parent::searchObjects($query));
    }

    public function update(ssf\MyObject $o): int|bool|null {
        $obj = $this->updateToObj($o);
        return parent::updateObject($this->getArray($o), $this->getFomato(), array(DBT_ID => $obj->getID()), array('%d'));
    }

    public function updateToObj(ssf\MyObject $o): Voce {
        return updateToVoce($o);
    }
    
    public function getResultByID($ID): Voce|null {
        $temp = parent::getResultByID($ID);        
        if($temp != null){
            return $this->getObj($temp);
        }
        return null;
    }

}
