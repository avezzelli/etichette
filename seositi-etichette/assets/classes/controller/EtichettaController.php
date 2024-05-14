<?php

namespace etichette;
use seositiframework as ssf;

class EtichettaController implements ssf\InterfaceController {
    
    private TemplateDAO $temDAO;
    private VoceDAO $vocDAO;
    private EtichettaDAO $etiDAO;
    private CategoriaDAO $catDAO;
    private TraduzioneController $traController;

    function __construct() {
        $this->temDAO = new TemplateDAO();
        $this->vocDAO = new VoceDAO();
        $this->etiDAO = new EtichettaDAO();
        $this->catDAO = new CategoriaDAO();
        $this->traController = new TraduzioneController();
    }

    public function delete(int $ID): bool {
        
    }

    public function get(int $ID): \seositiframework\MyObject {
        
    }

    public function save(\seositiframework\MyObject $o): bool {
        
    }

    public function update(\seositiframework\MyObject $o): bool|int {
        
    }
    
    /**** CATEGORIA ***/
    public function deleteCategoria(int $ID): bool{
        return $this->catDAO->deleteByID($ID);
    }
    
    public function saveCategoria(Categoria $obj): bool|int{
        return $this->catDAO->save($obj);
    }
    
    public function updateCategoria(Categoria $obj): int|bool{
        return $this->catDAO->update($obj);
    }
    
    public function getCategoriaByID(int $idCat): null|Categoria{
        return $this->catDAO->getResultByID($idCat);
    }
    
    public function getCategorie() : array{
        $result = array();
        $temp = $this->catDAO->getResults();
        if(ssf\checkResult($temp)){
            foreach($temp as $item){
                array_push($result, updateToCategoria($item));
            }
        }
        return $result;
    }
    
    public function getCategorieForm(): array{
        $result = array();
        $categorie = $this->getCategorie();
        if(ssf\checkResult($categorie)){
            foreach($categorie as $item){
                $categoria = updateToCategoria($item);
                $result[$categoria->getID()] = $categoria->getNome();
            }
        }
        return $result;
    }
    
    private function getIdCategoriaByName(string $nomeCategoria): int {
        $result = 0;
        $where = array(
            ssf\getQueryField(DBT_NOME, $nomeCategoria, ssf\Formato::TESTO())
        );
        $temp = $this->catDAO->getResults($where);
        //il nome è una discriminante quindi non ci possono essere risultati multipli
        if(ssf\checkResult($temp)){
            $result = updateToCategoria($temp[0]);
            $result = $result->getID();
        }
        return $result;
    }
    
    
    /**** VOCE ****/
    
    public function deleteVoce(int $ID): bool{
        return $this->vocDAO->deleteByID($ID);
    }
    
    public function deleteVociByTemplate(int $idTem): bool{
        //nel caso ci siano delle voci tradotte elimino anche loro        
        $where = array(DBT_ID_TEM => $idTem);          
        return $this->vocDAO->delete($where);
    }
    
    public function saveVoce(Voce $obj, int $idTem): bool|int{
        $obj->setIdTemplate($idTem);        
        return $this->vocDAO->save($obj);
    }
    
    public function updateVoce(Voce $obj): bool|int{
        return $this->vocDAO->update($obj);
    }
    
    public function getVoceByID(int $idVoce): null|Voce{
        return $this->vocDAO->getResultByID($idVoce);
    }
    
    private function getVociByTemplate(int $idTem): array{
        $result = array();
        $where = array(
            ssf\getQueryField(DBT_ID_TEM, $idTem, ssf\Formato::NUMERO())
        );
        $temp = $this->vocDAO->getResults($where);
        if(ssf\checkResult($temp)){
            foreach($temp as $item){
                array_push($result, updateToVoce($item));                
            }
        }        
        return $result;
    }   
    
        
    /*** TEMPLATE ***/
    
    public function deleteTemplate(int $ID): bool{
        //cancellare il template elimina anche tutte le voci inserite
        $this->deleteVociByTemplate($ID);
        //cancello anche le voci tradotte
        $this->traController->deleteVociTradotteByTemplate($ID);
        return $this->temDAO->deleteByID($ID);
    }
    
    public function saveTemplate(Template $obj): bool|int{       
        $idTem = $this->temDAO->save($obj);
        if($idTem > 0){
            //salvo le voci
            if(!$this->saveVoci($obj->getVoci(), $idTem)){
                return -2;
            }
        }        
        return $idTem;
    }
    
    private function saveVoci(array $array, int $idTem): bool{
        if(ssf\checkResult($array)){
            foreach($array as $item){
                $voce = updateToVoce($item);
                if(!$this->saveVoce($voce, $idTem)){
                    return -2;
                }
            }
            return true;
        }
        return false;
    }
    
    public function updateTemplate(Template|null $obj):bool|int{
        if($obj != null){
            //L'aggiornamento avviene in 2 fasi:
            //1. Aggiorno il template
            $update = $this->temDAO->update($obj);
            
            //2. salvo le voci (elimino quelle attuali e salvo le nuove)
            //Per via delle traduzioni non posso più permettermi di eliminare e salvare. 
            //Devo aggiornare voce per voce.
            foreach($obj->getVoci() as $item){
                $voce = updateToVoce($item);
                $this->updateVoce($voce);
            }
            //Aggiorno le voci tradotte
            if(ssf\checkResult($obj->getVociTradotte())){                
                foreach($obj->getVociTradotte() as $item){
                    $vt = updateToVoceTradotta($item);
                    $this->traController->updateVoceTradotta($vt);
                }
            }
               
            return $update;
        }
        return true;
    }
    
    //Ottengo tutte le etichette
    public function getTemplateByEtichetta(int $idEti): null|Template{
        $result = null;        
        $where = array(ssf\getQueryField(DBT_ID_ETI, $idEti, ssf\Formato::NUMERO()));        
        $temp = $this->temDAO->getResults($where);        
        if(ssf\checkResult($temp)){
            $result = updateToTemplate($temp[0]);
            $result->setVoci($this->getVociByTemplate($result->getID()));
            $result->setVociTradotte($this->traController->getVociTradotte($result->getID()));
        }              
        return $result;
    }
    
    
    public function getTemplateByID(int $idTem): null|Template{
        $result = $this->temDAO->getResultByID($idTem);
        if($result != null){
            $result->setVoci($this->getVociByTemplate($result->getID()));
            $result->setVociTradotte($this->traController->getVociTradotte($result->getID()));
        }
        return $result;
    }
    
    public function getTemplates(): array{
        $result = array();
        //devo ottenere i template che hanno il campo tipo = 1
        $where = array(
            ssf\getQueryField(DBT_TEM_TIPO, 1, ssf\Formato::NUMERO())
        );
        $temp = $this->temDAO->getResults($where);
        if(ssf\checkResult($temp)){
            foreach($temp as $item){                 
                array_push($result, updateToTemplate($item));
            }
        }
        return $result;
    }
    
    /**
     * Restituisce un array di template utilizzabile nei form
     * @return array
     */
    public function getTemplatesForm():array{
        $result = array();
        $templates = $this->getTemplates();
        if(ssf\checkResult($templates)){
            foreach($templates as $item){
                $template = updateToTemplate($item);
                $result[$template->getID()] = $template->getNome();
            }
        }        
        return $result;
    }
    
    /**
     * Restituisce un array di modelli template utilizzabili nei form di etichette
     * @return array
     */
    public function getModelliTemplate():array{
        $result = array();
        $templates = $this->getTemplates();
        if(ssf\checkResult($templates)){
            foreach($templates as $item){
                $tem = updateToTemplate($item);
                $result[$tem->getID()] = $tem->getNome();
            }
        }        
        return $result;
    }
    
 
    /***** ETICHETTE *****/
    public function deleteEtichetta(int $ID): bool{
        //elimino prima il template associato
        return $this->etiDAO->deleteByID($ID);
    }
    
    public function getEtichettaByID(int $ID): null|Etichetta{
        $result = $this->etiDAO->getResultByID($ID);
        if($result != null){            
            $result->setTemplate($this->getTemplateByEtichetta($result->getID()));
        }
        return $result;
    }
    
    public function saveEtichetta(Etichetta $etichetta, int $idTemplate): bool|int{
        //quando creo un etichetta, questa contiene un oggetto template
        //che a sua volta continene un array di voce. 
        //Salva etichetta li va ad inserire e salvare nel database    
        
        //NB. L'etichetta salvata deve avere un url univoco. 
        //1. Genero un codice alfanumerico unico  
        $url = $this->generateUniqueUrl();
        $etichetta->setUrl($url);  
        $etichetta->setLink(URL_ETICHETTA.$url);
        //2. Salvo l'etichetta ed ottengo idEti da passare al template
        $idEti = $this->etiDAO->save($etichetta);
        if($idEti > 0){
            //3. Salvo il template ed ottengo idTem da passare alle voci
            //sono in salvataggio e non ho un template già fatto, quindi lo creo da zero
            $modelloTemplate = $this->getTemplateByID($idTemplate);            
            $template = new Template();
            $template->setIdEtichetta($idEti);
            $template->setTipo(0); //indico che non è un modello
            $template->setVoci($modelloTemplate->getVoci());
            $template->setNome('');
            if(!$this->saveTemplate($template)){
               return false;
            }
        }  
        return true;        
    }
    
    public function updateEtichetta(Etichetta $etichetta): bool|int{
        //aggiorno il template e poi l'etichetta
        $update1 = $this->updateTemplate($etichetta->getTemplate());
        $update2 = $this->etiDAO->update($etichetta);
        if($update1 || $update2){
            return true;
        }        
        return false;
    }
    
    public function getEtichetteByCliente(int $idCliente):array{
        $result = array();
        $where = array(
            ssf\getQueryField(DBT_ID_CLI, $idCliente, ssf\Formato::NUMERO())
        );
        $temp = $this->etiDAO->getResults($where);
        if(ssf\checkResult($temp)){
            foreach($temp as $item){
                $eti = updateToEtichetta($item);
                $eti->setTemplate($this->getTemplateByEtichetta($eti->getID()));
                array_push($result, $eti);
            }
        }       
        return $result;
    }
    
    /**
     * Restituisce un array di etichette passando il nome della categoria 
     * @param string $nomeCategoria
     * @return array
     */
    public function getEtichetteByNomeCategoria(string $nomeCategoria):array{
        $result = array();
        $idCategoria = $this->getIdCategoriaByName($nomeCategoria);
        
        if($idCategoria != 0){
            $where = array(
                ssf\getQueryField(DBT_ID_CAT, $idCategoria, ssf\Formato::NUMERO())
            );

            $temp = $this->etiDAO->getResults($where);
            if(ssf\checkResult($temp)){
                foreach($temp as $item){
                    $eti = updateToEtichetta($item);
                    $eti->setTemplate($this->getTemplateByEtichetta($eti->getID()));
                    array_push($result, $eti);
                }
            }
        }
        return $result;
    }
    
    public function getEtichettaByUrl(string $url): Etichetta|null{
        $result = null;
        $where = array(ssf\getQueryField(DBT_ETI_URL, $url, ssf\Formato::TESTO()));
        $temp = $this->etiDAO->getResults($where);
        if(ssf\checkResult($temp)){
            $result = updateToEtichetta($temp[0]);
            $result->setTemplate($this->getTemplateByEtichetta($result->getID()));
        }        
        return $result;
    }
    
    public function getEtichette():array{
        $result = array();
        $temp = $this->etiDAO->getResults();        
        if(ssf\checkResult($temp)){
            foreach($temp as $item){
                $eti = updateToEtichetta($item);
                //$eti->setTemplate($this->getTemplateByEtichetta($eti->getID()));
                array_push($result, $eti);
            }
        }    
        return $result;
    }
   
    /**
     * La funzione controlla se un url è stato utilizzato.
     * @param string $url
     * @return bool
     */
    private function isUrlUsed(string $url): bool{        
        $where = array(
            ssf\getQueryField(DBT_ETI_URL, $url, ssf\Formato::TESTO())
        );
        $temp = $this->etiDAO->getResults($where);
        if(ssf\checkResult($temp)){
           //vuol dire che ha trovato un risultato
            return true;
        }
        return false;       
    }
    
    /**
     * La funzione genere un url univoco controllando prima gli altri url generati
     * @return string
     */
    private function generateUniqueUrl(): string{
        $url = generateRandomString();
        if($this->isUrlUsed($url)){
            $this->generateUniqueUrl();
        }
        else{
            return $url;
        }
    }
    
    

}
