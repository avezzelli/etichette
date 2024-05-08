<?php

namespace etichette;
use seositiframework as ssf;

class ClienteView extends ssf\PrinterView implements ssf\InterfaceView {

   private ClienteController $controller; 
    
    function __construct() {
        parent::__construct();
        $this->controller = new ClienteController();
    }

    /*** LISTENER ***/
    public function listenerDetailsForm() {
        
    }

    public function listenerSaveForm() {
        
    }
    
    public function listenerClienteForm(): string|null{
        $cli = $this->clienteCheckFields();             
        //Salvataggio
        if(isset($_POST[FRM_CLI.FRM_SAVE])){
            //controllo il cliente            
            if($cli != null){
                //salvo l'utente WP
                $uWp = parent::utenteWpCheckFields();
                $idWp = $uWp->save();
                if($idWp){
                    $cli->setIdWP($idWp);
                }
                //salvo il cliente nel DB
                $save = $this->controller->save($cli);
                if($save > 0){
                    unset($_POST);
                }
                return $this->printMessageAfterSave('Cliente', $save);
            }
        }
        //Aggiornamento
        else if(isset($_POST[FRM_CLI.FRM_UPDATE])){ 
            $uWpUdate = false;            
            //caso in cui ho un cliente che non ha associato un UWP
            if($_POST[FRM_UWP.FRM_ID] == 0 && $_POST[FRM_UWP.FRM_EMAIL] != ''){
                //se il campo mail è compilato allora posso creare l'utente                
                if($cli != null){
                    $uWp = parent::utenteWpCheckFields($_POST[FRM_UWP.FRM_EMAIL]);
                    $idWp = $uWp->save();
                    if($idWp){
                        $cli->setIdWP($idWp);
                    }                    
                }
            }
            else if($_POST[FRM_UWP.FRM_ID] == 0 && $_POST[FRM_UWP.FRM_EMAIL] == ''){
                //se il campo mail non è compilato aggiorno solo cliente senza salvare l'utente
            }
            else if($_POST[FRM_UWP.FRM_ID] != 0){                
                //se esiste UtenteWP allora aggiorno tutto
                $uWp = parent::utenteWpCheckFields();  
                if($uWp->update()){
                    $uWpUdate = true;
                }
                
            }
            //Aggiorno il cliente nel DB
            $update = $this->controller->update($cli);
            if($update || $uWpUdate){
                return $this->printMessageAfterUpdate(true);
            }
            return $this->printMessageAfterUpdate(false);
            
        }
        //Cancellazione
        else if(isset($_POST[FRM_CLI.FRM_DELETE])){            
            if($cli != null){
                //elimino l'utenteWP
                if($cli->getIdWP() != 0){
                   $uWp = parent::utenteWpCheckFields();
                   $uWp->delete();
                }
                $delete = $this->controller->delete($cli->getID());
                return $this->printMessageAfterDelete($delete);
            }
        }
        
        return null;
    }

    public function printDetailsForm(int $ID): string {
        $uWp = null;
        $html = '';
        //ottengo il cliente dall'ID
        $cliente = $this->controller->get($ID);
        if($cliente != null){   
            $html.= $this->printTitoloPagina('Dettaglio Cliente');
            $fields = $this->getClienteFormFields($cliente);
            $fields .= parent::getUtenteWpFormFields($cliente->getIdWP());
            $form = parent::detailForm(FRM_CLI, $fields);
            $html .= parent::addContainer($form);            
        }else{
            $html .= parent::printErrorBoxMessage('Utente non trovato.');
        }
        
        return $html;
    }

    
    /*** SALVATAGGI ***/
    public function printSaveForm(): string {
        $html = '';
        
        $html.= parent::printTitoloPagina('Salva Cliente');
        
        $fields = $this->getClienteFormFields();         
        $fields .= parent::getUtenteWpFormFields();
        $form = parent::saveForm(FRM_CLI, $fields);
        
        $html .= parent::addContainer($form);
        
        return $html;
    }
    
    
    private function getClienteFormFields(Cliente $cliente=null):string{
        $html = '';
        $html .= '<fieldset class="form-group border p-3">';   
        $html .= '<legend class="w-auto px-1">Campi Cliente</legend>';
        
        if($cliente != null){
            //si tratta di aggiornamento
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), FRM_CLI.FRM_ID, '', ssf\Richiesto::NO(), $cliente->getID());
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::NASCOSTO(), FRM_UWP.FRM_ID, '', ssf\Richiesto::NO(), $cliente->getIdWP());
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::TESTO(), FRM_CLI.FRM_NOME, LBL_NOME, ssf\Richiesto::SI(), $cliente->getNome());
        }
        else{
            //si tratta di salvataggio
            $html .= parent::printInput(ssf\Modello::FLOAT(), ssf\Campo::TESTO(), FRM_CLI.FRM_NOME, LBL_NOME, ssf\Richiesto::SI());
        }
        
        $html .= '</fieldset>';
        
        return $html;
    }
    
    /*** CHECK **/
    private function clienteCheckFields():Cliente|null{
        
        $cliente = new Cliente();              
        //ID: not required
        if(parent::check(ssf\Campo::TESTO(), FRM_CLI.FRM_ID, '') !== false){
            $cliente->setID(parent::check(ssf\Campo::TESTO(), FRM_CLI.FRM_ID, ''));
        }
        
        //Nome: required
        if(parent::check(ssf\Campo::TESTO(), FRM_CLI.FRM_NOME, LBL_NOME) !== false){
            $cliente->setNome(parent::check(ssf\Campo::TESTO(), FRM_CLI.FRM_NOME, LBL_NOME));
        }
        else{
            return null;
        }
        
        //IdWP: required
        if(parent::check(ssf\Campo::TESTO(), FRM_UWP.FRM_ID, '', ssf\Obbligatorio::SI()) !== false){
            $cliente->setIdWP(parent::check(ssf\Campo::TESTO(), FRM_UWP.FRM_ID, '', ssf\Obbligatorio::SI()));
        }
        
        return $cliente;
    }

    
    /************** TABELLE ***************/
    public function printTabellaClienti(): string{
        $result = parent::printTitoloTabella('Lista Clienti');
        //ottengo l'header
        $header = $this->getHeader();
        //ottengo le righe
        $rows = $this->getRowsCliente();
        if($rows == null){
            $result .= parent::printAlert('Non sono stati trovati clienti.');
        }
        else{
            $result .= parent::printTable(FRM_CLI, $header, $rows);
        }
        
        return $result;
    }
    
    
    private function getHeader(): array{
        return array('ID', LBL_NOME);
    }
    
    private function getRowsCliente(): array|null{
        $temp = $this->controller->getClienti();
        if(ssf\checkResult($temp)){
            $rows = array();
            foreach($temp as $item){
                array_push($rows, $this->getColonne($item) );
            }
            return $rows;
        }
        return null;
    }
    
    private function getColonne(Cliente $cliente):array{
        $colonne = array();
        array_push($colonne, $cliente->getID());
        array_push($colonne, parent::printUrl($cliente->getNome(), URL_DETTAGLIO_CLIENTE.$cliente->getID()));
        //array_push($colonne, '0'); //DA SOSTITUIRE APPENA SI CREA LA FUNZIONE
        return $colonne;
    }
}
