<?php

namespace etichette;
use seositiframework as ssf;

class VoceTradottaDAO extends ssf\ObjectDAO implements ssf\InterfaceDAO {

    function __construct() {
        parent::__construct(DBT_VTR);
    }

    public function deleteByID($ID): bool {
        return parent::deleteObjectByID($ID);
    }
    
    public function delete(array $where):bool{
        return parent::deleteObject($where);
    }

    public function exists(\seositiframework\MyObject $o): bool {
        //per non creare doppioni i discriminanti sono il campo id_voce e lang
        $obj = $this->updateToObj($o);
        $where = array();
        if($obj->getIdVoce() != '' && $obj->getIdVoce() != null){
            array_push($where, ssf\getQueryField(DBT_ID_VOC, $obj->getIdVoce(), ssf\Formato::NUMERO()));
        }
        if($obj->getLang() != '' && $obj->getLang() != null){
            array_push($where, ssf\getQueryField(DBT_VTR_LANG, $obj->getLang(), ssf\Formato::TESTO()));
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
            DBT_ID_VOC      => $obj->getIdVoce(),
            DBT_VTR_LANG    => $obj->getLang(), 
            DBT_ID_TEM      => $obj->getIdTemplate(),
            DBT_VTR_LBL     => $obj->getLabel(),
            DBT_VTR_VAL     => $obj->getValore(),
            DBT_VTR_TIP     => $obj->getTipo(),
            DBT_VTR_VIS     => $obj->getVisualizza()
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
        return array('%d', '%s', '%d', '%s', '%s', '%s', '%d');
    }

    public function getObj($item) {
        $obj = $this->newObj();
        $obj->setID($item[DBT_ID]);
        $obj->setIdVoce($item[DBT_ID_VOC]);
        $obj->setLang($item[DBT_VTR_LANG]);
        $obj->setIdTemplate($item[DBT_ID_TEM]);
        $obj->setLabel($item[DBT_VTR_LBL]);
        $obj->setValore($item[DBT_VTR_VAL]);
        $obj->setTipo($item[DBT_VTR_TIP]);
        $obj->setVisualizza($item[DBT_VTR_VIS]);
        return $obj;
    }

    public function getResults($where = null, $order = null): array|null {
        return $this->getArrayResult(parent::getObjectsDAO($where, $order));
    }

    public function newObj() {
        return new VoceTradotta();
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

    public function updateToObj(\seositiframework\MyObject $o): VoceTradotta {
        return updateToVoceTradotta($o);
    }
    
    public function getResultByID($ID): VoceTradotta|null {
        $temp = parent::getResultByID($ID);        
        if($temp != null){
            return $this->getObj($temp);
        }
        return null;
    }
}
