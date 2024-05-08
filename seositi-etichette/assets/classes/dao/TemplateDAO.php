<?php

namespace etichette;
use seositiframework as ssf;

class TemplateDAO extends ssf\ObjectDAO implements ssf\InterfaceDAO {

    function __construct() {
        parent::__construct(DBT_TEM);
    }

    public function deleteByID($ID): bool {
        return parent::deleteObjectByID($ID);
    }

    public function exists(\seositiframework\MyObject $o): bool {
        $obj = $this->updateToObj($o);
        //Il discriminante è il nome del template (se presente)
        $where = array();        
        if($obj->getNome() != '' && $obj->getNome() != null){
            array_push($where, ssf\getQueryField(DBT_NOME, $obj->getNome(), 'TEXT'));
            $resQuery = parent::getObjectsDAO($where);
            if(!ssf\checkResult($resQuery)){
                return false;
            }
        }
        else if($obj->getNome() == ''){
            return false;
        }
        return true;
    }

    public function getArray(\seositiframework\MyObject $o): array {
        $obj = $this->updateToObj($o);
        return array(
            DBT_NOME        => $obj->getNome(),
            DBT_TEM_TIPO    => $obj->getTipo(),
            DBT_ID_ETI      => $obj->getIdEtichetta()
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
        return array('%s', '%d', '%d');
    }

    public function getObj($item): Template {
        $obj = $this->newObj();
        $obj->setID($item[DBT_ID]);
        $obj->setNome($item[DBT_NOME]);
        $obj->setTipo($item[DBT_TEM_TIPO]);
        $obj->setIdEtichetta($item[DBT_ID_ETI]);
        return $obj;
    }

    public function getResults($where = null, $order = null): array|null {       
        return $this->getArrayResult(parent::getObjectsDAO($where, $order));
    }

    public function newObj(): Template {
        return new Template();
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

    public function updateToObj(\seositiframework\MyObject $o): Template {
        return updateToTemplate($o);
    }

    public function getResultByID($ID): Template|null {
        $temp = parent::getResultByID($ID);        
        if($temp != null){
            return $this->getObj($temp);
        }
        return null;
    }

}
