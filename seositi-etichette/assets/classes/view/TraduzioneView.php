<?php

namespace etichette;
use seositiframework as ssf;

class TraduzioneView extends ssf\PrinterView implements ssf\InterfaceView {

    private TraduzioneController $controller;
    private array $lingue;
    
    function __construct() {
        parent::__construct();
        $this->controller = new TraduzioneController();
        $this->lingue = $this->controller->getLingue();
    }

    /*** LISTENER ***/
    public function listenerDetailsForm() {
        
    }

    public function listenerSaveForm() {
        
    }

    public function printDetailsForm(int $ID): string {
        
    }

    public function printSaveForm(): string {
     
    }
    
    public function listenerTraduzioni(): string|null{
        $lingue = $this->traduzioniCheckFields();
        if(isset($_POST[FRM_TRA.FRM_SAVE])){
            //il salvataggio comporta l'azzeramento delle traduzioni salvate e il salvataggio di quelle ottenute
            $save = $this->controller->salvaTraduzioni($lingue);
            if($save > 0){
                unset($_POST);
            }
            return $this->printMessageAfterSave('Lingue', $save);
        }
        
        return null;
    }
    
    
    public function attivaTraduzioni():string{
        $html = '';
        $traduzioni = $this->controller->getTraduzioni();
        
        $html .= parent::printTitoloPagina('Traduzioni');        
        
        $fields = '';
        if($traduzioni == null){
            //non ho traduzioni 
            $fields .= parent::printCheckBox(ssf\Modello::DUE_COLONNE(), FRM_TRA_LINGUA, LBL_LINGUA, $this->lingue);
        }
        else{
            $lingue = array();
            foreach($traduzioni as $item){
                $temp = updateToTraduzione($item);
                array_push($lingue, $temp->getLingua());
            }
            //ho traduzioni
            $fields .= parent::printCheckBox(ssf\Modello::DUE_COLONNE(), FRM_TRA_LINGUA, LBL_LINGUA, $this->lingue, $lingue);
        } 
        $form = parent::saveForm(FRM_TRA, $fields);
        $html .= parent::addContainer($form);        
        return $html;
    }
    
    
     /*** CHECK **/
    private function traduzioniCheckFields(): array{
        
        $result = array();        
        //Lingua: not required
        if(parent::check(ssf\Campo::CHECKBOX(), FRM_TRA_LINGUA, LBL_LINGUA) !== false){
            $result = parent::check(ssf\Campo::CHECKBOX(), FRM_TRA_LINGUA, LBL_LINGUA);
        }                
        return $result;
    }
}
