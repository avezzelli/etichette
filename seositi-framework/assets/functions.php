<?php

namespace seositiframework;

function curPageURL() {
    $pageURL = 'http';     
        
    if ($_SERVER["HTTPS"] == "on") { 
        $pageURL .= "s"; 
    } 
         
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
     $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
     $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

/**
 * Controlla se il valore passato contiene risultati
 * @param type $temp
 * @return boolean
 */
function checkResult($temp){
    if($temp != null && count($temp) > 0){
        return true;
    }
    return false;
}

function getRoleUser(){
    if(is_user_logged_in()){
        $user = wp_get_current_user();
        return (array) $user->roles;
    }
    else{
        return false;
    }
}

/**
 * La funzione restituisce il valore di un parametro passato per $_GET
 * @param string $parametro
 * @return null|string
 */
function getUrlGETInfo(string $parametro): null|string{
    $result = null;
    if(isset($_GET) && count($_GET) > 0){
        if(isset($_GET[$parametro])){
            return $_GET[$parametro];
        }
    }
    return $result;
}

//INSERISCO FUNZIONI PERSONALIZZATE

/**
 * Devo ottenere la mail dell'utente WP conoscendo il suo ID. 
 * @param int $id
 * @return string
 */
function getEmailByWpId(int $id): string{
    $user = get_userdata($id);
    return $user->user_email;
}

/** miglioro l'inserimento dei dati nel database  */
function getSingleField($nome, $tipo, $null): array{
    return array(
        'nome'  => $nome,
        'tipo'  => $tipo, 
        'null'  => $null
    );
}

function getQueryField($campo, $valore, $formato): array{
    return array(
        'campo'     => $campo,
        'valore'    => $valore,
        'formato'   => $formato
    );      
}

function getFKs(string $id, string $tabella): array{
    return array(
        'key1'      => $id,
        'tabella'   => $tabella
    );
}


/*** CREAZIONE PAGINE ***/
function createPage(string $titolo){
    $args = array(
        'post_title'    => $titolo,
        'post_content'  => '',
        'post_type'     => 'page',
        'post_status' => 'publish',
    );
       
    if(post_exists($titolo) == 0){
        return wp_insert_post($args);    
    }
    return 0;    
}

