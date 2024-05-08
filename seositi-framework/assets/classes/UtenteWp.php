<?php

namespace seositiframework;

/**
 * UtenteWp è la classe che permette ad eventuali classi utenti di 
 * interfacciarsi con l'utente wordpress
 *
 * @author SeoSiti Developing Team
 */
class UtenteWp {

    private int $ID;
    private string $nome;
    private string $cognome;
    private string $email;
    private string $ruolo;
    private string $password;
    private string $nicename;   
    
    function __construct() {
        $this->ID = 0;
        $this->nome = '';
        $this->cognome = '';
        $this->email = '';
        $this->ruolo = '';
        $this->password = '';
        $this->nicename = '';       
    }
    
    public function getNome(): string {
        return $this->nome;
    }

    public function getCognome(): string {
        return $this->cognome;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getRuolo(): string {
        return $this->ruolo;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getNicename(): string {
        return $this->nicename;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function setCognome(string $cognome): void {
        $this->cognome = $cognome;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setRuolo(string $ruolo): void {
        $this->ruolo = $ruolo;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function setNicename(string $nicename): void {
        $this->nicename = $nicename;
    }
    
    public function getID(): int {
        return $this->ID;
    }

    public function setID(int $ID): void {
        $this->ID = $ID;
    }
        
    public function save():int|bool{
        //salvo l'utente solo se ho una mail inserita
        if($this->email != null && $this->email != ''){        
            if($this->password == null){
                //se non è presente una password, ne viene generata una randomica
                $this->password = wp_generate_password();
            }
            $userdata = array(
                'user_login'    => $this->email,
                'user_email'    => $this->email,
                'role'          => $this->ruolo,
                'first_name'    => $this->nome,
                'last_name'     => $this->cognome,
                'user_pass'     => $this->password,
                'user_nicename' => $this->nicename
            );
            $idWP = wp_insert_user($userdata);
            if(is_wp_error($idWP)){           
                return false;
            }        
            return $idWP;
        }
        return false;
    }
    
    public function get(int $idWp):void{
        $user = get_user_by('id', $idWp);
        $this->ID = $idWp;
        $this->nome = $user->first_name;
        $this->cognome = $user->last_name;
        $this->email = $user->user_email;
        $this->nicename = $user->user_nicename;
        $this->password = $user->user_pass;
    }
    
    public function delete():bool{
        return wp_delete_user($this->ID);
    }
    
    public function update():bool{
        $userdata = null;        
        if($this->password != null && $this->password != ''){
            $userdata = array(
                'ID'       => $this->ID,
                'first_name'    => $this->nome,
                'last_name'     => $this->cognome,
                'user_pass'     => $this->password,
                'user_nicename' => $this->nicename
            );
        }
        else{
            $userdata = array(
                'ID'       => $this->ID,
                'first_name'    => $this->nome,
                'last_name'     => $this->cognome,
                'user_nicename' => $this->nicename
            );
        }
        
        $update = wp_update_user($userdata);
        if(is_wp_error($update)){
            return false;
        }
        return true;        
    }

}
