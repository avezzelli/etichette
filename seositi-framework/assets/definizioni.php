<?php

namespace seositiframework;

/************************ DEFINIZIONI **************************/
define('ELEMENTI_PER_PAGINA', 10);
define('DBT_ID', 'ID');
define('FRM_ID', '-id');
define('FRM_NOME', '-nome');
define('FRM_COGNOME', '-cognome');
define('FRM_EMAIL', '-email');
define('FRM_PSW', '-password');
define('FRM_TIPO', '-tipo');

/*** LABEL ***/
define('LBL_NOME', 'Nome');
define('LBL_COGNOME', 'Cognome');
define('LBL_EMAIL', 'Email');
define('LBL_PASSWORD', 'Password'); 

/*** DEFINIZIONI DI PRINTER-VIEW ***/
define('FRM_ADD', 'form-add-');
define('FRM_DETAILS', 'form-details-');
define('FRM_SAVE', '-save-form');
define('FRM_UPDATE', '-update-form');
define('FRM_DELETE', '-delete-form');
define('FRM_SEARCH', '-search-form');
define('FRM_SEARCH_SUBMIT', 'form-search-submit');
define('FRM_SEARCH_RESET', 'form-search-reset');
define('COLONNA_ETICHETTA', 'col-sm-3');
define('COLONNA_CONTENUTO', 'col-sm-9');


/*** DEFINIZIONI UTENTE WP ***/
define('FRM_UWP', 'uwp');


/** FORMATO VARIABILI **/
class Formato{
    
    public static function NUMERO(){
        return 'INT';
    }
    public static function TESTO(){
        return 'TEXT';
    }
    public static function DATA(){
        return 'TIMESTAMP';
    }   
    public static function OBBLIGATORIO(){
        return 'NOT NULL';
    }
    public static function FACOLTATIVO(){
        return 'NULL';
    }
}

class Campo{    
    public static function NASCOSTO(){
        return 'hidden';
    }
    public static function TESTO(){
        return 'text';
    }
    public static function TELEFONO(){
        return 'tel';
    }
    public static function EMAIL(){
        return 'email';
    }
    public static function PASSWORD(){
        return 'password';
    }
    public static function PREZZO(){
        return 'price';
    }
    public static function AREA_DI_TESTO(){
        return 'textarea';
    }
    public static function IMMAGINE(){
        return 'img';
    }    
    public static function NUMERO(){
        return 'number';
    }
    public static function FILE(){
        return 'file';
    }   
    public static function EDITOR(){
        return 'editor';
    }
    public static function CHECKBOX(){
        return 'checkbox';
    }
    public static function SELECT(){
        return 'select';
    }
    public static function DATA(){
        return 'date';
    }
}

class Target{
    public static function NUOVA_FINESTRA(){
        return '_blank';
    }
}

class Modello{
    public static function FLOAT(){
        return 'float';
    }
    public static function DUE_COLONNE(){
        return 'due-colonne';
    }
}

class Richiesto{
    public static function NO(){
        return '';
    }
    public static function SI(){
        return 'required';
    }
}

class Disabilitato{
    public static function NO(){
        return '';
    }
    public static function SI(){
        return 'disabled';
    }
    public static function SOLA_LETTURA(){
        return 'readonly';
    }
}

class Obbligatorio{
    public static function SI(){
        return true;
    }
    public static function NO(){
        return false;
    }
}

class TypeSelect{
    public static function SINGLE(){
        return 'single';
    }    
    public static function MULTIPLE(){
        return 'multiple';
    }
}