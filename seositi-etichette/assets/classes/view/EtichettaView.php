<?php

namespace etichette;
use seositiframework as ssf;

class EtichettaView extends ssf\PrinterView implements ssf\InterfaceView{
    
    private EtichettaController $controller;
    private ClienteController $cliente;
    private TraduzioneController $tradC;
    private array $tipoVoce;
    private array $visualizzaVoce;

    function __construct() {
        $this->controller = new EtichettaController();
        $this->cliente = new ClienteController();
        $this->tradC = new TraduzioneController();
        $this->tipoVoce = array(
            ssf\Campo::IMMAGINE()   => 'Immagine',
            ssf\Campo::TESTO()      => 'Editor'
        );
        
        $this->visualizzaVoce = array(
            NASCONDI => 'Nascondi Label',
            VISUALIZZA => 'Mostra Label'
        );
    }

    public function listenerDetailsForm() {
        
    }

    public function listenerSaveForm() {
        
    }

    public function printDetailsForm(int $ID): string {
        $html = '';
        
        return $html;
    }

    public function printSaveForm(): string {
        $html = '';
        
        return $html;
    }
    
    /*************************************************************/
    /********************** CATEGORIA ****************************/
    /*************************************************************/
    
    public function printCategoriaSaveForm(): string{        
        $html = parent::printTitoloTabella('Salva Categoria');
        $fields = $this->getCategoriaFormFields();
        $form = parent::saveForm(FRM_CAT, $fields);
        $html .= parent::addContainer($form);
        return $html;
    }
    
    public function printCategoriaDetailsForm(int $ID): string{
        $html = '';
        $cat = $this->controller->getCategoriaByID($ID);
        if($cat != null){
            $html .= $this->printTitoloPagina('Dettaglio Categoria');
            $fields = $this->getCategoriaFormFields($cat);
            $form = parent::detailForm(FRM_CAT, $fields);
            $html .= parent::addContainer($form);            
        }
        else{
            $html .= parent::printErrorBoxMessage('Categoria non trovata');
        }
        
        return $html;
    }
    
    
    private function getCategoriaFormFields(Categoria $cat=null):string{
        $html = '';
        $html .= '<fieldset class="form-group border p-3">';   
        $html .= '<legend class="w-auto px-1">Campi Categoria</legend>';
        
        if($cat != null){
            //si tratta di aggiornamento
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), FRM_CAT.FRM_ID, '', ssf\Richiesto::NO(), $cat->getID());
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::TESTO(), FRM_CAT.FRM_NOME, LBL_NOME, ssf\Richiesto::SI(), $cat->getNome());
        }
        else{
            //si tratta di salvataggio
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::TESTO(), FRM_CAT.FRM_NOME, LBL_NOME, ssf\Richiesto::SI());
        }
        
        $html .= '</fieldset>';
        
        return $html;
    }
    
    public function listenerCategoriaForm(): string|null{
       $cat = $this->categoriaCheckFields();
       //Salvataggio
        if($cat != null){
            if(isset($_POST[FRM_CAT.FRM_SAVE])){                
                $save = $this->controller->saveCategoria($cat);
                if($save > 0){
                    unset($_POST);
                }
                return $this->printMessageAfterSave('Categoria', $save);                
            }
            //Aggiornamento
            else if(isset($_POST[FRM_CAT.FRM_UPDATE])){                
                $update = $this->controller->updateCategoria($cat);                
                return $this->printMessageAfterUpdate($update);
            }
            //Cancellazione
            else if(isset($_POST[FRM_CAT.FRM_DELETE])){
                $delete = $this->controller->deleteCategoria($cat->getID());
                return $this->printMessageAfterDelete($delete);
            }
       }
       return null;
    }
    
    private function categoriaCheckFields(): Categoria|null{
        $cat = new Categoria();
        //ID: not required
        if(parent::check(ssf\Campo::TESTO(), FRM_CAT.FRM_ID, '') !== false){
            $cat->setID(parent::check(ssf\Campo::TESTO(), FRM_CAT.FRM_ID, ''));
        }
        
        //Nome: required
        if(parent::check(ssf\Campo::TESTO(), FRM_CAT.FRM_NOME, '') !== false){
            $cat->setNome(parent::check(ssf\Campo::TESTO(), FRM_CAT.FRM_NOME, ''));
        }
        else{
            return null;
        }        
        return $cat;
    }
    
    public function printTabellaCategorie(): string{
        $result = parent::printTitoloTabella('Lista Categorie');
        //ottengo l'header
        $header = $this->getCategorieHeader();
        //ottengo le righe
        $rows = $this->getCategorieRows();
        if($rows == null){
            $result .= parent::printAlert('Non sono state trovate categorie');
        }
        else{
            $result .= parent::printTable(FRM_CAT, $header, $rows);
        }
        return $result;
    }
    
    private function getCategorieHeader():array{
        return array('ID', LBL_NOME);
    }
    
    private function getCategorieRows(): array|null{
        $temp = $this->controller->getCategorie();
        if(ssf\checkResult($temp)){
            $rows = array();
            foreach($temp as $item){
                array_push($rows, $this->getCategoriaColonne($item) );
            }
            return $rows;
        }
        return null;
    }
    
    private function getCategoriaColonne(Categoria $cat):array{
        $colonne = array();
        array_push($colonne, $cat->getID());
        array_push($colonne, parent::printUrl($cat->getNome(), URL_DETTAGLIO_CATEGORIA.$cat->getID()));
        //array_push($colonne, '0'); //DA SOSTITUIRE APPENA SI CREA LA FUNZIONE
        return $colonne;
    }

    /*************************************************************/
    /********************** FINE CATEGORIA ***********************/
    /*************************************************************/
    
    
    /*************************************************************/
    /********************** TEMPLATE ****************************/
    /*************************************************************/
    
    public function listenerTemplateForm(): string|null{
        $template = $this->templateCheckFields();
        
        if($template != null){
            //Salvataggio
            if(isset($_POST[FRM_TEM.FRM_SAVE])){
                //imposto il tipo a modello
                $template->setTipo(1);
                $save = $this->controller->saveTemplate($template);
                if($save > 0){
                    unset($_POST);
                }
                return $this->printMessageAfterSave('Template', $save);
            }
            //Aggiornamento
            else if(isset($_POST[FRM_TEM.FRM_UPDATE])){
                //imposto il tipo a modello
                $template->setTipo(1);
                $update = $this->controller->updateTemplate($template);
                return $this->printMessageAfterUpdate($update);
            }
            //Cancellazione
            else if(isset($_POST[FRM_TEM.FRM_DELETE])){
                $delete = $this->controller->deleteTemplate($template->getID());
                return $this->printMessageAfterDelete($delete);
            }
        }        
        return null;
    }
    
    public function printTemplateSaveForm():string{
        $html = parent::printTitoloTabella('Salva template');
        $fields = $this->getTemplateFormFields();
        $form = parent::saveForm(FRM_TEM, $fields);
        $html .= parent::addContainer($form);        
        return $html;
    }
    
    public function printTemplateDetailsForm(int $ID): string{
        $html = '';
        $template = $this->controller->getTemplateByID($ID);
        if($template != null){
            $html .= $this->printTitoloPagina('Dettaglio Template');
            $fields = $this->getTemplateFormFields($template);
            $form = parent::detailForm(FRM_TEM, $fields);
            $html .= parent::addContainer($form);
        }
        else{
            $html .= parent::printErrorBoxMessage('Template non trovato.');
        }        
        return $html;
    }
    
    private function getTemplateFormFields(Template $temp=null):string{
        $html = '';
        $html .= '<fieldset class="form-group border p-3">';   
        $html .= '<legend class="w-auto px-1">Campi Template</legend>';
        
        if($temp != null){
            //si tratta di aggiornamento
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), FRM_TEM.FRM_ID, '', ssf\Richiesto::NO(), $temp->getID());
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), FRM_TEM_IDETI, '', ssf\Richiesto::NO(), $temp->getIdEtichetta());
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::TESTO(), FRM_TEM.FRM_NOME, LBL_NOME, ssf\Richiesto::NO(), $temp->getNome());
            //ottengo le voci
            $html .= $this->printVociForm($temp->getVoci());
        }
        else{
            //si tratta di salvataggio
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::TESTO(), FRM_TEM.FRM_NOME, LBL_NOME);
            //ottengo le voci 
            $html .= $this->printVociForm();
        }
        $html .= '</fieldset>';
        
        return $html;
    }
    
    private function printVociForm(array $arrayVoci=null):string{
        $html = '';
        $html .= '<script type="text/javascript">';
        $html .=    'var labelVoce = "'.FRM_VOC_LBL.'";';
        $html .=    'var visualizzaVoce = "'.FRM_VOC_VIS.'";';
        $html .=    'var tipoVoce = "'.FRM_VOC_TIP.'";';        
        $html .= '</script>';
        
        $html .= parent::printTitoloTabella('Voci');
        
        $divContent = '';
        if($arrayVoci == null || count($arrayVoci) == 0){
            $divContent .= $this->getVoceForm('1');
        }
        else{
            $counter = 1;
            foreach($arrayVoci as $item){
                $voce = updateToVoce($item);
                $divContent .= $this->getVoceForm($counter, $voce);
                $counter++;
            }
        }
      
        $divContainer = parent::printDiv($divContent, 'container-voci');
        $html .= $divContainer;       
        $html .= $this->printBottoneAggiungiVoce();
        
        return $html;
    }
    
    private function getVoceForm(int $counter, Voce $voce=null): string{
        $html = '';
        
        if($voce != null){
            //aggiornamento
            $divContent = '';
            $divContent .= parent::printDiv(parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), 'count-voce-'.$counter, '', '', $counter), 'countvoce');
            $divContent .= parent::printDiv(parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), 'id-voce-'.$counter, '', '', $voce->getID()), 'id-voce');
            $divContent .= parent::printDiv(parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), 'id-template-'.$counter, '', '', $voce->getIdTemplate()), 'id-template');
            $divContent .= parent::printDiv(parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::TESTO(), FRM_VOC_LBL.'-'.$counter, LBL_LABEL, ssf\Richiesto::SI(), $voce->getLabel()), 'label');
            $divContent .= parent::printDiv(parent::printSelect(ssf\Modello::FLOAT(), ssf\TypeSelect::SINGLE(), FRM_VOC_VIS.'-'.$counter, LBL_VISUALIZZA, $this->visualizzaVoce, ssf\Richiesto::SI(), $voce->getVisualizza()), 'visualizza');
            $divContent .= parent::printDiv(parent::printSelect(ssf\Modello::FLOAT(), '',  FRM_VOC_TIP.'-'.$counter, LBL_TIPO, $this->tipoVoce, ssf\Richiesto::SI(), $voce->getTipo()), 'tipo');            
            $divContent .= $this->printBottoneAggiornaVoce();
            $divContent .= $this->printBottoneRimuoviVoce();
            
            $divContainer = parent::printDiv($divContent, 'voce', 'num', $counter);
            $html .= $divContainer;
            
        }
        else{
            //salvataggio
            $divContent = '';
            $divContent .= parent::printDiv(parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), 'count-voce-'.$counter, '', '', $counter), 'countvoce');
            $divContent .= parent::printDiv(parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::TESTO(), FRM_VOC_LBL.'-'.$counter, LBL_LABEL, ssf\Richiesto::SI()), 'label');
            $divContent .= parent::printDiv(parent::printSelect(ssf\Modello::FLOAT(), ssf\TypeSelect::SINGLE(), FRM_VOC_VIS.'-'.$counter, LBL_VISUALIZZA, $this->visualizzaVoce, ssf\Richiesto::SI()), 'visualizza');
            $divContent .= parent::printDiv(parent::printSelect(ssf\Modello::FLOAT(), '',  FRM_VOC_TIP.'-'.$counter, LBL_TIPO, $this->tipoVoce, ssf\Richiesto::SI()), 'tipo');            
            $divContent .= $this->printBottoneRimuoviVoce();
            $divContainer = parent::printDiv($divContent, 'voce', 'num', $counter);
            $html .= $divContainer;
        }
        
        return $html;
    }
    
    private function getTemplateForEtichettaForm(Template|null $template):string{
        $html = '';
        if($template != null){                                      
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), FRM_TEM.FRM_ID, '', ssf\Richiesto::NO(), $template->getID());
            //ottengo le voci
            
             /*** QUI CI VA IL METODO PER OTTENERE LE TRADUZIONI SE SONO STATE ATTIVATE ***/
            //controllo se ho traduzioni disponibili, in caso affermativo aggiunto accanto a voci il codice della lingua. 
            $lingueAttive = $this->tradC->getLingueAttive();
            $lingue = $this->tradC->getLingue();
            
            if(ssf\checkResult($lingueAttive)){                                                
                //procedo con le traduzioni 
                $dati = array();               
                
                //valore di default in italiano
                $data = array();
                $data['prefisso'] = 'it';
                $data['titolo'] = 'VOCI [italiano]';
                $data['contenuto'] = $this->getVociForETichettaForm($template->getVoci());
                array_push($dati, $data);
                
                $vociTradotte = $template->getVociTradotte();
                               
                //ciclo sulle lingue attive
                foreach($lingueAttive as $lingua){
                    $data = array();
                    $data['prefisso'] = $lingua;
                    $data['titolo'] = 'VOCI ['.$lingue[$lingua].']';
                    
                    //ottengo i valori del contenuto
                    $data['contenuto'] = $this->getVociTradotteForEtichettaForm($vociTradotte, $lingua);                    
                    array_push($dati, $data);
                }                                
                $html .= parent::printTabSection('traduzioni', $dati);               
            }
            else{
                //procedo senza traduzioni, esiste solo l'italiano
                $html .= parent::printTitolo('h4', 'Voci', 'margin-50');
                $html .= $this->getVociForETichettaForm($template->getVoci());    
            }
        }
        else{
            $html .= '<p>Questa etichetta non possiede voci da compilare.</p>';
        }
        return $html;
    }
    
    private function getVociForETichettaForm(array $voci): string{
        $html = '';
        if(ssf\checkResult($voci)){
            $counter = 1;
            foreach($voci as $item){
                $voce = updateToVoce($item);
                $html .= $this->getVoceForEtichettaForm($voce->getID(), $voce);
                $counter++;
            }
        }        
        return $html;
    }
    
    private function getVociTradotteForEtichettaForm(array $vociTradotte, string $lang): string{
        $html = '';
        if(ssf\checkResult($vociTradotte)){
            $counter = 1;
            foreach($vociTradotte as $item){
                $vt = updateToVoceTradotta($item);
                if($vt->getLang() == $lang){
                    $html .= $this->getVoceTradottaForEtichettaForm($vt->getID(), $vt);
                    $counter++;
                }
            }
        }
        
        return $html;
    }
    
    private function getVoceForEtichettaForm(int $counter, Voce $voce):string{
        $html = '';        
        if($voce != null){
            $campo = ssf\Campo::EDITOR();            
            if($voce->getTipo() == ssf\Campo::IMMAGINE()){
                $campo = ssf\Campo::IMMAGINE();
            }   
            $divContent = '';
            $divContent .= parent::printDiv(parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), 'count-voce-'.$counter, '', '', $counter), 'countvoce');
            $divContent .= parent::printDiv(parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), 'id-voce-'.$counter, '', '', $voce->getID()), 'id-voce');           
            $divContent .= parent::printDiv(parent::printInput(ssf\Modello::DUE_COLONNE(), $campo, FRM_VOC_VAL.'-'.$counter, $voce->getLabel(), ssf\Richiesto::NO(), $voce->getValore()), 'valore');
            $divContainer = parent::printDiv($divContent, 'voce', 'num', $counter);
            $html .= $divContainer;
            
            //parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::IMMAGINE(), FRM_ETI_IMMAGINE, LBL_IMMAGINE, ssf\Richiesto::NO(), $eti->getImmagine());
        }        
        return $html;
    }
    
    private function getVoceTradottaForEtichettaForm(int $counter, VoceTradotta $vt):string{
        $html = '';
        if($vt != null){
            $campo = ssf\Campo::EDITOR();  
            if($vt->getTipo() == ssf\Campo::IMMAGINE()){
                $campo = ssf\Campo::IMMAGINE();
            }
            $divContent = '';
            $divContent .= parent::printDiv(parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), 'count-vt-'.$counter, '', '', $counter), 'countvoce');
            $divContent .= parent::printDiv(parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), 'id-vt-'.$counter, '', '', $vt->getID()), 'id-vt'); 
            $divContent .= parent::printDiv(parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), 'lang-vt-'.$counter, '', '', $vt->getLang()), 'lang-vt');
            $divContent .= parent::printDiv(parent::printInput(ssf\Modello::DUE_COLONNE(), $campo, FRM_VTR_VAL.'-'.$counter, $vt->getLabel(), ssf\Richiesto::NO(), $vt->getValore()), 'valore');
            $divContainer = parent::printDiv($divContent, 'voce', 'num', $counter);
            $html .= $divContainer;
        }        
        return $html;
    }
        
    private function printBottoneAggiungiVoce():string{
        return parent::printDiv(parent::printUrl('Aggiungi voce', null, 'btn'), 'aggiungi-voce').'<hr>';
    }
    
    private function printBottoneRimuoviVoce():string{
        return parent::printDiv(parent::printUrl('Rimuovi voce'), 'btn rimuovi-voce');
    }
    
    private function printBottoneAggiornaVoce():string{
        return parent::printDiv(parent::printUrl('Aggiorna voce'), 'btn aggiorna-voce');
    }
    
    private function templateCheckFields(): Template|null{
        
        $template = new Template();
        
        //ID: not required
        if(parent::check(ssf\Campo::TESTO(), FRM_TEM.FRM_ID, '') !== false){
            $template->setID(parent::check(ssf\Campo::TESTO(), FRM_TEM.FRM_ID, ''));
        }        
        //ID etichetta: not required
        if(parent::check(ssf\Campo::TESTO(), FRM_ETI.FRM_ID, '') !== false){
            $template->setIdEtichetta(parent::check(ssf\Campo::TESTO(), FRM_ETI.FRM_ID, ''));
        }        
        //Nome: required
        if(parent::check(ssf\Campo::TESTO(), FRM_TEM.FRM_NOME, LBL_NOME) !== false){
            $template->setNome(parent::check(ssf\Campo::TESTO(), FRM_TEM.FRM_NOME, LBL_NOME));
        }
        
        //Voci        
        $template->setVoci($this->vociCheckFields());
        
        //Voci Tradotte
        $template->setVociTradotte($this->vociTradotteCheckFields());
        
        return $template;
        
    }
    
    private function vociCheckFields():array|null{
        $result = array();
        $errors = 0;  
         
        foreach($_POST as $key => $value){
            if(strpos($key, 'count-voce')!== false){
                $voce = new Voce();
                if(isset($_POST['id-voce-'.$value])){
                    //si tratta di aggiornamento
                    $voce->setID($_POST['id-voce-'.$value]);
                    //ottengo altri campi
                    $t = $this->controller->getVoceByID($voce->getID());
                    if($t != null){
                        $temp = updateToVoce($t);
                        //setto i vari campi
                        $voce->setIdTemplate($temp->getIdTemplate());
                        $voce->setLabel($temp->getLabel());
                        $voce->setVisualizza($temp->getVisualizza());
                        $voce->setTipo($temp->getTipo());  
                        
                        //valore  
                        $campo = ssf\Campo::TESTO();
                        if($voce->getTipo() == ssf\Campo::IMMAGINE()){
                            $campo = ssf\Campo::IMMAGINE();
                        }                        
                        if(parent::check($campo, FRM_VOC_VAL.'-'.$value, LBL_VALORE) !== false){
                            $voce->setValore(parent::check($campo, FRM_VOC_VAL.'-'.$value, LBL_VALORE));
                        }
                       
                    }
                }
                else{
                    //si tratta di salvataggio                    
                    //label: required
                    if(parent::check(ssf\Campo::TESTO(), FRM_VOC_LBL.'-'.$value, LBL_LABEL) !== false){
                        $voce->setLabel(parent::check(ssf\Campo::TESTO(), FRM_VOC_LBL.'-'.$value, LBL_LABEL));
                    }
                    else{
                        $errors++;
                    }
                    //visualizza: required
                    if(parent::check(ssf\Campo::TESTO(), FRM_VOC_VIS.'-'.$value, LBL_VISUALIZZA) !== false){
                        //lo converto in int perchè nel db il campo è intero
                        $voce->setVisualizza(intval(parent::check(ssf\Campo::TESTO(), FRM_VOC_VIS.'-'.$value, LBL_VISUALIZZA)));
                    }
                    else{
                        echo 'dentro';
                        $errors++;
                    }
                    //tipo: required 
                    if(parent::check(ssf\Campo::TESTO(), FRM_VOC_TIP.'-'.$value, LBL_TIPO) !== false){
                        $voce->setTipo(parent::check(ssf\Campo::TESTO(), FRM_VOC_TIP.'-'.$value, LBL_TIPO));
                    }
                    else{
                        $errors++;
                    }
                    //il campo voce nel salvataggio del template non è previsto
                    $voce->setValore('');
                }
                             
                if($errors > 0){
                    return null;
                }
                //carico la voce nell'array
                array_push($result, $voce);
            }
        }        
        return $result;
    }
    
    private function vociTradotteCheckFields():array|null{
        $result = array();
                
        foreach($_POST as $key=>$value){
            if(strpos($key, 'count-vt')!== false){
                $vt = new VoceTradotta();
                //Questa voce sarà sempre aggiornata e mai salvata. 
                //Il salvataggio avviene nel momento del refresh della pagina ed è gestito da checkVociTradotta
                if(isset($_POST['id-vt-'.$value])){
                    $vt->setID($_POST['id-vt-'.$value]);
                    //ottengo altri campi non inclusi in questo form
                    $t = $this->tradC->getVoceTradotta($vt->getID());
                    if($t != null){
                        $temp = updateToVoceTradotta($t);
                        $vt->setIdVoce($temp->getIdVoce());
                        $vt->setIdTemplate($temp->getIdTemplate());
                        $vt->setLabel($temp->getLabel());
                        $vt->setVisualizza($temp->getVisualizza());
                        $vt->setTipo($temp->getTipo());
                        $vt->setLang($temp->getLang());
                        
                        //valore
                        $campo = ssf\Campo::TESTO();
                        if($vt->getTipo() == ssf\Campo::IMMAGINE()){
                            $campo = ssf\Campo::IMMAGINE();
                        }  
                        if(parent::check($campo, FRM_VTR_VAL.'-'.$value, LBL_VALORE) !== false){
                            $vt->setValore(parent::check($campo, FRM_VTR_VAL.'-'.$value, LBL_VALORE));
                        }
                    }
                }
                array_push($result, $vt);
            }
        }
        return $result;
    }
        
    public function printTabellaTemplate(): string{
        $result = parent::printTitoloTabella('Lista Template');
        //ottengo l'header
        $header = $this->getTemplateHeader();
        //ottengo le righe
        $rows = $this->getTemplateRows();
        if($rows == null){
            $result .= parent::printAlert('Non sono stati trovati template.');
        }
        else{
            $result .= parent::printTable(FRM_TEM, $header, $rows);
        }
        return $result; 
    }
    
    private function getTemplateHeader():array{
        return array('ID', LBL_NOME);
    }
    
    private function getTemplateRows(): array|null{
        $temp = $this->controller->getTemplates();
        if(ssf\checkResult($temp)){
            $rows = array();
            foreach($temp as $item){
                array_push($rows, $this->getTemplateColonne($item));
            }
            return $rows; 
        }
        return null;
    }
    
    private function getTemplateColonne(Template $tem):array{
        $colonne = array();
        array_push($colonne, $tem->getID());
        array_push($colonne, parent::printUrl($tem->getNome(), URL_DETTAGLIO_TEMPLATE.$tem->getID()));
        return $colonne;
    }
    
    /*************************************************************/
    /********************** FINE TEMPLATE ****************************/
    /*************************************************************/
    
    
    /*************************************************************/
    /********************** ETICHETTA ****************************/
    /*************************************************************/
    
    public function printEtichettaSaveForm():string{
        $html = '';
        $html .= parent::printTitoloTabella('Salva Etichetta');
        $fields = $this->getEtichettaFormFields();
        $form = parent::saveForm(FRM_ETI, $fields);
        $html .= parent::addContainer($form);        
        return $html;
    }
    
    public function printEtichettaDetailsForm(int $ID): string{
        $html = '';
        $etichetta = $this->controller->getEtichettaByID($ID);
        
        if($etichetta != null){
            //Azione per le traduzioni
            $this->checkVociTradotte($etichetta);
            //faccio un check ulteriore per includere quelle voci che possono essere state tradotte in questo momento
            $etichetta = $this->controller->getEtichettaByID($ID);                        
            $html .= $this->printTitoloPagina('Dettaglio Etichetta');
            $fields = $this->getEtichettaFormFields($etichetta);
            $form = parent::detailForm(FRM_ETI, $fields, true);
            $html .= parent::addContainer($form);
        }
        else{
            $html .= parent::printErrorBoxMessage('Etichetta non trovata.');
        }
        return $html;
    }
    
    public function printEtichetta(string $url):string{
        $html = '';
        
        //ottengo l'etichetta dall'url
        $etichetta = $this->controller->getEtichettaByUrl($url);
        if($etichetta != null){
            //$html.= $this->printTitoloPagina($etichetta->getNome());
            $html .= $this->getEtichettaForFrontEnd($etichetta);
        }
        else{
            $html .= parent::printErrorBoxMessage('Etichetta non trovata.');
        }
       
        
        return $html;
    }
    
    /**
     * Stampa a video la pagina di front end dell'etichetta
     * @param Etichetta $eti
     * @return string
     */
    private function getEtichettaForFrontEnd(Etichetta $eti):string{
        $html = '';
        $linguaSelezionata = '';
        if(isset($_GET['lang'])){
            $linguaSelezionata = $_GET['lang'];
        }
        
        //Menu lingue
        if(ssf\checkResult($this->tradC->getLingueAttive())){
            $html .= $this->printMenuLingue($eti);
        }
        
        $template = $eti->getTemplate();
        if($linguaSelezionata == ''){            
            foreach($template->getVoci() as $item){
                $voce = updateToVoce($item);            
                $html .= $this->printTemplate($voce->getVisualizza(), $voce->getTipo(), $voce->getLabel(), $voce->getValore());
            }
        }

        //Voci tradotte
        if(ssf\checkResult($this->tradC->getLingueAttive())){
            foreach($template->getVociTradotte() as $item){
                $vt = updateToVoceTradotta($item);
                if($vt->getLang() == $linguaSelezionata){
                    $html .= $this->printTemplate($vt->getVisualizza(), $vt->getTipo(), $vt->getLabel(), $vt->getValore());
                }
            }
            
        }
        
        return $html;
    }
    
    private function printTemplate(int $visualizza, string $tipo, string $label, string $valore):string{
        $html = '';
        //verifica se label è visibile o meno
        if($visualizza == VISUALIZZA){
            $content = parent::printDiv(parent::strongText($label), 'sinistra');
        }
        else if($visualizza == NASCONDI){
            $content = parent::printDiv('', 'sinistra');
        }
        $valore = stripslashes($valore);
        if($tipo == ssf\Campo::IMMAGINE()){                
            $img = parent::printImage($valore);
            $valore = parent::printUrl($img, $valore, '', ssf\Target::NUOVA_FINESTRA());
        }
        $content .= parent::printDiv($valore, 'destra');
        $divContainer = parent::printDiv($content, 'voce');
        $html .= $divContainer;        
        return $html; 
    }
    
    private function printMenuLingue(Etichetta $eti):string{
        $html = '';
        $lingueAttive = $this->tradC->getLingueAttive();
        $url = $eti->getLink();
        $urlImg = plugins_url('/seositi-etichette/images/lang/') ;
        $html .= '<nav class="lingue-attive">';
        $html .= '<a href="'.$url.'" ><img src="'.$urlImg.'it.svg" /></a>';
        foreach($lingueAttive as $lingua){
            $html .= '<a href="'.$url.'&lang='.$lingua.'"><img src="'.$urlImg.$lingua.'.svg" /></a>';
        }
        
        $html .= '</nav>';
        
        return $html;
    }
    
    private function getEtichettaFormFields(Etichetta $eti=null):string{
        $html = '';
        $html .= '<fieldset class="form-group border p-3">';
        $html .= '<legend class="w-auto px-1">Campi Etichetta</legend>';
        
        if($eti != null){
            $template = $eti->getTemplate(); //ottengo il template che è specifico e non un modello            
            //si tratta di aggiornamento            
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), FRM_ETI.FRM_ID, '', ssf\Richiesto::NO(), $eti->getID());
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::TESTO(), FRM_ETI.FRM_NOME, LBL_NOME, ssf\Richiesto::SI(), $eti->getNome());
            //cliente
            $html .= parent::printSelect(ssf\Modello::FLOAT(), ssf\TypeSelect::SINGLE(), FRM_ETI_CLIENTE, LBL_CLIENTE, $this->cliente->getClientiForm(), ssf\Richiesto::SI(), $eti->getIdCliente());
            //categoria
            $html .= parent::printSelect(ssf\Modello::FLOAT(), ssf\TypeSelect::SINGLE(), FRM_ETI_CATEGORIA, LBL_CATEGORIA, $this->controller->getCategorieForm(), ssf\Richiesto::SI(), $eti->getIdCategoria());
            //url
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::TESTO(), FRM_ETI_URL, LBL_URL, ssf\Richiesto::SI(), $eti->getUrl(), ssf\Disabilitato::NO());
            //link
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::TESTO(), FRM_ETI_LINK, LBL_LINK, ssf\Richiesto::SI(), $eti->getLink(), ssf\Disabilitato::SOLA_LETTURA());
            //immagine
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::IMMAGINE(), FRM_ETI_IMMAGINE, LBL_IMMAGINE, ssf\Richiesto::NO(), $eti->getImmagine());
                        
            //TEMPLATE
            $html .= $this->getTemplateForEtichettaForm($template);   
        }
        else{
            //si tratta di salvataggio
            //non ho un template specifico ma posso scegliere sul modello da selezionare
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::TESTO(), FRM_ETI.FRM_NOME, LBL_NOME, ssf\Richiesto::SI());
            //cliente
            $html .= parent::printSelect(ssf\Modello::FLOAT(), ssf\TypeSelect::SINGLE(), FRM_ETI_CLIENTE, LBL_CLIENTE, $this->cliente->getClientiForm(), ssf\Richiesto::SI());
            //categoria
            $html .= parent::printSelect(ssf\Modello::FLOAT(), ssf\TypeSelect::SINGLE(), FRM_ETI_CATEGORIA, LBL_CATEGORIA, $this->controller->getCategorieForm(), ssf\Richiesto::SI());
            //template
            $html .= parent::printSelect(ssf\Modello::FLOAT(), ssf\TypeSelect::SINGLE(), FRM_ETI_TEMPLATE, LBL_TEMPLATE, $this->controller->getTemplatesForm(), ssf\Richiesto::SI());            
        }
        
        $html .= '</fieldset>';
        return $html;
    }
    
    public function listenerEtichettaForm(): string|null{ 
        //Salvataggio
        if(isset($_POST[FRM_ETI.FRM_SAVE])){  
            $etichetta = $this->etichettaCheckFields();  

            if($etichetta != null){
                $template = $etichetta->getTemplate();
                $save = $this->controller->saveEtichetta($etichetta, $etichetta->getIdModelloTemplate());
                if($save > 0){
                    unset($_POST);
                }
                return $this->printMessageAfterSave('Etichetta', $save);
            }
        }
        //Aggiornamento
        else if(isset($_POST[FRM_ETI.FRM_UPDATE])){            
            $etichetta = $this->etichettaCheckFields();             
            if($etichetta != null){
                $update = $this->controller->updateEtichetta($etichetta);
                return $this->printMessageAfterUpdate($update);
            }       
        }
        //Cancellazione
        else if(isset($_POST[FRM_ETI.FRM_DELETE])){
            $etichetta = $this->etichettaCheckFields();
            if($etichetta != null){
                $template = $etichetta->getTemplate();
                if($template != null){
                    $this->controller->deleteTemplate($template->getID());
                }                    
                $delete = $this->controller->deleteEtichetta($etichetta->getID());
                return $this->printMessageAfterDelete($delete);
            }
        }
        
        return null;
    }
    
    
    private function etichettaCheckFields(): Etichetta|null{
        $etichetta = new Etichetta();
        
        //ad ettichetta è associato un oggetto template che al salvataggio non esiste,
        //mentre esiste all'aggiornamento. Per ottenerlo bisogna fare una query sui template
        //ed estrarre quello che ha l'id etichetta
        
        //ID: not required
        if(parent::check(ssf\Campo::TESTO(), FRM_ETI.FRM_ID, '') !== false){
            $etichetta->setID(parent::check(ssf\Campo::TESTO(), FRM_ETI.FRM_ID, ''));
            //in questo caso sono nella casistica di aggiornamento e ottengo anche il template            
            $etichetta->setTemplate($this->templateCheckFields()); 
        }
        else{
            //sono nella casistica di salvataggio quindi devo salvare le voci e fare un check su di esse            
            $template = new Template();
            $template = $this->templateCheckFields();            
            $etichetta->setTemplate($template);            
        }
        
        //Nome: required
        if(parent::check(ssf\Campo::TESTO(), FRM_ETI.FRM_NOME, LBL_NOME) !== false){
            $etichetta->setNome(parent::check(ssf\Campo::TESTO(), FRM_ETI.FRM_NOME, LBL_NOME));
        }
        else{
            echo 'dentro1';
            return null;
        }
        
        //Cliente: required
        if(parent::check(ssf\Campo::TESTO(), FRM_ETI_CLIENTE, LBL_CLIENTE) !== false){
            $etichetta->setIdCliente(parent::check(ssf\Campo::TESTO(), FRM_ETI_CLIENTE, LBL_CLIENTE));
        }
        else{  
            echo 'dentro2';
            return null;
        }
        
        //Categoria: required
        if(parent::check(ssf\Campo::TESTO(), FRM_ETI_CATEGORIA, LBL_CATEGORIA) !== false){
            $etichetta->setIdCategoria(parent::check(ssf\Campo::TESTO(), FRM_ETI_CATEGORIA, LBL_CATEGORIA));
        }
        else{
            echo 'dentro3';
            return null;
        }
        
        //Url: required
        if(parent::check(ssf\Campo::TESTO(), FRM_ETI_URL, LBL_URL) !== false){
            $etichetta->setUrl(parent::check(ssf\Campo::TESTO(), FRM_ETI_URL, LBL_URL));
            //elaboro già il link associato all'url (vanno in coppia questi due campi)
            $etichetta->setLink(URL_ETICHETTA.$etichetta->getUrl());
        }
        
        /*
        //link: not required
        if(parent::check(ssf\Campo::TESTO(), FRM_ETI_LINK, LBL_LINK) !== false){
            $etichetta->setLink(parent::check(ssf\Campo::TESTO(), FRM_ETI_LINK, LBL_LINK));
        }
        */
        
        //modello template
        if(parent::check(ssf\Campo::TESTO(), FRM_ETI_TEMPLATE, LBL_TEMPLATE) !== false){
            $etichetta->setIdModelloTemplate(parent::check(ssf\Campo::TESTO(), FRM_ETI_TEMPLATE, LBL_TEMPLATE));
        }
        
        //Immagine: not required
        if(parent::check(ssf\Campo::IMMAGINE(), FRM_ETI_IMMAGINE, LBL_IMMAGINE) !== false){
            $etichetta->setImmagine(parent::check(ssf\Campo::IMMAGINE(), FRM_ETI_IMMAGINE, LBL_IMMAGINE));
        }
               
        return $etichetta;
    }
    
    public function printTabellaEtichette(array $etichette=null): string{
        $html = parent::printTitoloTabella('Lista Etichette');
        //ottengo l'header
        $header = $this->getEtichetteHeader();
        //ottengo le righe
        $rows = $this->getEtichetteRows($etichette);
        if($rows == null){
            $html .= parent::printAlert('Non sono state trovate etichette.');
        }
        else{
            $html .= parent::printTable(FRM_ETI, $header, $rows);
        }        
        return $html;
    }
    
    private function getEtichetteHeader():array{
        return array('ID', LBL_NOME, LBL_CLIENTE, LBL_CATEGORIA, LBL_LINK);
    }
    
    private function getEtichetteRows(array $etichette=null):array|null{
        if($etichette == null){            
            $etichette = $this->controller->getEtichette();            
        }             
        if(ssf\checkResult($etichette)){
            $rows = array();
            foreach($etichette as $item){                
                array_push($rows, $this->getEtichetteColonne($item));
            }            
            return $rows;
        }
        return null;
    }
    
    private function getEtichetteColonne(Etichetta $eti): array{
        $colonne = array();
        
        array_push($colonne, $eti->getID());
        array_push($colonne, parent::printUrl($eti->getNome(), URL_DETTAGLIO_ETICHETTA.$eti->getID()));        
        array_push($colonne, getNomeCliente($eti->getIdCliente()));        
        array_push($colonne, getNomeCategoria($eti->getIdCategoria()));       
        array_push($colonne, $eti->getLink());
        
        return $colonne;
    }
    
    public function printEtichetteByNomeCategoria(string $nomeCategoria):string{
        $html = '';
        //ottengo l'array
        $etichette = $this->controller->getEtichetteByNomeCategoria($nomeCategoria);        
        
        $html .= '<div class="categoria-container">';
        foreach($etichette as $item){
            $eti = updateToEtichetta($item);
            $html .= '<a class="etichetta-singola" href="'.URL_ETICHETTA.$eti->getUrl().'">';
            $html .= '<img src="'.$eti->getImmagine().'">';
            $html .= '<h5>'.$eti->getNome().'</h5>';
            $html .= '</a>';
        }
        
        $html .= '</div>';
        
        
        return $html;
    }
    
    /**
     * La funzione verifica se ci sono i campi attivi per le traduzioni delle voci template salvate nelle etichette
     * @param Etichetta $etichetta
     * @return void
     */
    private function checkVociTradotte(Etichetta $etichetta): void{
        //devo verificare che l'etichetta abbia le traduzioni attive         
        $lingue = $this->tradC->getLingueAttive(); 
        if(ssf\checkResult($lingue)){
            //in questo caso ci sono le lingue attive e proseguo nel verificare se ci sono voci tradotte            
            //ottengo il template per verificare le voci
            $template = $etichetta->getTemplate();
            $voci = $template->getVoci();
            //devo ciclare all'interno delle voci del template e verificare se c'è la corrispondenza con le voci tradotte
            foreach($lingue as $lingua){
                foreach($voci as $item){
                    $voce = updateToVoce($item);
                    if(!$this->tradC->checkVoceTradotta($voce->getID(), $lingua)){
                        //non ho trovato la voce la creo!                        
                        if($voce->getID() > 0){                            
                            $vt = $this->copyVoceinVoceTradotta($voce, $lingua);
                            $this->tradC->saveVoceTradotta($vt);
                        }
                    }                    
                }
            }
        }        
    }
    
    /**
     * La funzione copia i campi di voce in un ogetto VoceTradotta
     * @param Voce $voce
     * @return VoceTradotta
     */
    private function copyVoceinVoceTradotta(Voce $voce, string $lingua):VoceTradotta{
        $vt = new VoceTradotta();
        $vt->setIdVoce($voce->getID());
        $vt->setLang($lingua);
        $vt->setIdTemplate($voce->getIdTemplate());
        $vt->setLabel($voce->getLabel());
        $vt->setValore($voce->getValore());
        $vt->setTipo($voce->getTipo());
        $vt->setVisualizza($voce->getVisualizza());
        return $vt;
    }
    
    
    /*************************************************************/
    /********************** FINE ETICHETTA ****************************/
    /*************************************************************/
}
