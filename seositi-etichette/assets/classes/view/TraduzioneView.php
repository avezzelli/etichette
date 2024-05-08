<?php

namespace etichette;
use seositiframework as ssf;

class TraduzioneView extends ssf\PrinterView implements ssf\InterfaceView {

    private TraduzioneController $controller;
    private array $lingue;
    
    function __construct() {
        parent::__construct();
        $this->controller = new TraduzioneController();
        $this->lingue = array(
            'en' => 'English',
            'fr' => 'Français',
            'de' => 'Deutsch'
        );
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
    
    
    public function attivaTraduzioni():string{
        $html = '';
        $traduzioni = $this->controller->getTraduzioni();
        
        $html .= parent::printTitoloPagina('Traduzioni');        
        
        $fields = '';
        if($traduzioni==null){
            //non ho traduzioni 
            $fields .= parent::printCheckBox(ssf\Modello::DUE_COLONNE(), FRM_TRA_LINGUA, LBL_LINGUA, $this->lingue);
        }
        else{
            //ho traduzioni
            $fields .= parent::printCheckBox(ssf\Modello::DUE_COLONNE(), FRM_TRA_LINGUA, LBL_LINGUA, $this->lingue, $traduzioni);
        } 
        $form = parent::saveForm(FRM_TRA, $fields);
        $html .= parent::addContainer($form);        
        return $html;
    }
}
