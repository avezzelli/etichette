<?php

namespace seositiframework;

/**
 * Classe base della view che identifica tutti i metodi di stampa 
 *
 * @author SeoSiti Developing Team
 */
class PrinterView {

    private array $mesi;
    private array $giorni;
    private $annoCorrente;
    private $meseCorrente;
    private $giornoCorrente;
    private $settimanaCorrente;
    private array $countries;
    private array $province;
    private array $operatore;
    
    function __construct() {
        $this->operatore = array('<=' => '<=', '>=' => '>=');        
        $this->mesi = array('01' => 'Gennaio', '02' => 'Febbraio', '03' => 'Marzo', '04' => 'Aprile', '05' => 'Maggio', '06' => 'Giugno', '07' => 'Luglio', '08' => 'Agosto', '09' => 'Settembre', '10' => 'Ottobre', '11' => 'Novembre', '12' => 'Dicembre');        
        $this->giorni = array('1'  => 'Lunedì', '2'  => 'Martedì', '3'  => 'Mercoledì', '4'  => 'Giovedì', '5'  => 'Venerdì', '6'  => 'Sabato', '7'  => 'Domenica');        
        $this->countries=array('AF'=>'Afghanistan','AX'=>'Aland Islands','AL'=>'Albania','DZ'=>'Algeria','AS'=>'American Samoa','AD'=>'Andorra','AO'=>'Angola','AI'=>'Anguilla','AQ'=>'Antarctica','AG'=>'Antigua And Barbuda','AR'=>'Argentina','AM'=>'Armenia','AW'=>'Aruba','AU'=>'Australia','AT'=>'Austria','AZ'=>'Azerbaijan','BS'=>'Bahamas','BH'=>'Bahrain','BD'=>'Bangladesh','BB'=>'Barbados','BY'=>'Belarus','BE'=>'Belgium','BZ'=>'Belize','BJ'=>'Benin','BM'=>'Bermuda','BT'=>'Bhutan','BO'=>'Bolivia','BA'=>'Bosnia And Herzegovina','BW'=>'Botswana','BV'=>'Bouvet Island','BR'=>'Brazil','IO'=>'British Indian Ocean Territory','BN'=>'Brunei Darussalam','BG'=>'Bulgaria','BF'=>'Burkina Faso','BI'=>'Burundi','KH'=>'Cambodia','CM'=>'Cameroon','CA'=>'Canada','CV'=>'Cape Verde','KY'=>'Cayman Islands','CF'=>'Central African Republic','TD'=>'Chad','CL'=>'Chile','CN'=>'China','CX'=>'Christmas Island','CC'=>'Cocos (Keeling) Islands','CO'=>'Colombia','KM'=>'Comoros','CG'=>'Congo','CD'=>'Congo, Democratic Republic','CK'=>'Cook Islands','CR'=>'Costa Rica','CI'=>'Cote D\'Ivoire','HR'=>'Croatia','CU'=>'Cuba','CY'=>'Cyprus','CZ'=>'Czech Republic','DK'=>'Denmark','DJ'=>'Djibouti','DM'=>'Dominica','DO'=>'Dominican Republic','EC'=>'Ecuador','EG'=>'Egypt','SV'=>'El Salvador','GQ'=>'Equatorial Guinea','ER'=>'Eritrea','EE'=>'Estonia','ET'=>'Ethiopia','FK'=>'Falkland Islands (Malvinas)','FO'=>'Faroe Islands','FJ'=>'Fiji','FI'=>'Finland','FR'=>'France','GF'=>'French Guiana','PF'=>'French Polynesia','TF'=>'French Southern Territories','GA'=>'Gabon','GM'=>'Gambia','GE'=>'Georgia','DE'=>'Germany','GH'=>'Ghana','GI'=>'Gibraltar','GR'=>'Greece','GL'=>'Greenland','GD'=>'Grenada','GP'=>'Guadeloupe','GU'=>'Guam','GT'=>'Guatemala','GG'=>'Guernsey','GN'=>'Guinea','GW'=>'Guinea-Bissau','GY'=>'Guyana','HT'=>'Haiti','HM'=>'Heard Island & Mcdonald Islands','VA'=>'Holy See (Vatican City State)','HN'=>'Honduras','HK'=>'Hong Kong','HU'=>'Hungary','IS'=>'Iceland','IN'=>'India','ID'=>'Indonesia','IR'=>'Iran, Islamic Republic Of','IQ'=>'Iraq','IE'=>'Ireland','IM'=>'Isle Of Man','IL'=>'Israel','IT'=>'Italy','JM'=>'Jamaica','JP'=>'Japan','JE'=>'Jersey','JO'=>'Jordan','KZ'=>'Kazakhstan','KE'=>'Kenya','KI'=>'Kiribati','KR'=>'Korea','KW'=>'Kuwait','KG'=>'Kyrgyzstan','LA'=>'Lao People\'s Democratic Republic','LV'=>'Latvia','LB'=>'Lebanon','LS'=>'Lesotho','LR'=>'Liberia','LY'=>'Libyan Arab Jamahiriya','LI'=>'Liechtenstein','LT'=>'Lithuania','LU'=>'Luxembourg','MO'=>'Macao','MK'=>'Macedonia','MG'=>'Madagascar','MW'=>'Malawi','MY'=>'Malaysia','MV'=>'Maldives','ML'=>'Mali','MT'=>'Malta','MH'=>'Marshall Islands','MQ'=>'Martinique','MR'=>'Mauritania','MU'=>'Mauritius','YT'=>'Mayotte','MX'=>'Mexico','FM'=>'Micronesia, Federated States Of','MD'=>'Moldova','MC'=>'Monaco','MN'=>'Mongolia','ME'=>'Montenegro','MS'=>'Montserrat','MA'=>'Morocco','MZ'=>'Mozambique','MM'=>'Myanmar','NA'=>'Namibia','NR'=>'Nauru','NP'=>'Nepal','NL'=>'Netherlands','AN'=>'Netherlands Antilles','NC'=>'New Caledonia','NZ'=>'New Zealand','NI'=>'Nicaragua','NE'=>'Niger','NG'=>'Nigeria','NU'=>'Niue','NF'=>'Norfolk Island','MP'=>'Northern Mariana Islands','NO'=>'Norway','OM'=>'Oman','PK'=>'Pakistan','PW'=>'Palau','PS'=>'Palestinian Territory, Occupied','PA'=>'Panama','PG'=>'Papua New Guinea','PY'=>'Paraguay','PE'=>'Peru','PH'=>'Philippines','PN'=>'Pitcairn','PL'=>'Poland','PT'=>'Portugal','PR'=>'Puerto Rico','QA'=>'Qatar','RE'=>'Reunion','RO'=>'Romania','RU'=>'Russian Federation','RW'=>'Rwanda','BL'=>'Saint Barthelemy','SH'=>'Saint Helena','KN'=>'Saint Kitts And Nevis','LC'=>'Saint Lucia','MF'=>'Saint Martin','PM'=>'Saint Pierre And Miquelon','VC'=>'Saint Vincent And Grenadines','WS'=>'Samoa','SM'=>'San Marino','ST'=>'Sao Tome And Principe','SA'=>'Saudi Arabia','SN'=>'Senegal','RS'=>'Serbia','SC'=>'Seychelles','SL'=>'Sierra Leone','SG'=>'Singapore','SK'=>'Slovakia','SI'=>'Slovenia','SB'=>'Solomon Islands','SO'=>'Somalia','ZA'=>'South Africa','GS'=>'South Georgia And Sandwich Isl.','ES'=>'Spain','LK'=>'Sri Lanka','SD'=>'Sudan','SR'=>'Suriname','SJ'=>'Svalbard And Jan Mayen','SZ'=>'Swaziland','SE'=>'Sweden','CH'=>'Switzerland','SY'=>'Syrian Arab Republic','TW'=>'Taiwan','TJ'=>'Tajikistan','TZ'=>'Tanzania','TH'=>'Thailand','TL'=>'Timor-Leste','TG'=>'Togo','TK'=>'Tokelau','TO'=>'Tonga','TT'=>'Trinidad And Tobago','TN'=>'Tunisia','TR'=>'Turkey','TM'=>'Turkmenistan','TC'=>'Turks And Caicos Islands','TV'=>'Tuvalu','UG'=>'Uganda','UA'=>'Ukraine','AE'=>'United Arab Emirates','GB'=>'United Kingdom','US'=>'United States','UM'=>'United States Outlying Islands','UY'=>'Uruguay','UZ'=>'Uzbekistan','VU'=>'Vanuatu','VE'=>'Venezuela','VN'=>'Viet Nam','VG'=>'Virgin Islands, British','VI'=>'Virgin Islands, U.S.','WF'=>'Wallis And Futuna','EH'=>'Western Sahara','YE'=>'Yemen','ZM'=>'Zambia','ZW'=>'Zimbabwe',);
        $this->province=array('AG'=>'Agrigento','AL'=>'Alessandria','AN'=>'Ancona','AO'=>'Aosta','AR'=>'Arezzo','AP'=>'Ascoli Piceno','AT'=>'Asti','AV'=>'Avellino','BA'=>'Bari','BT'=>'Barletta-Andria-Trani','BL'=>'Belluno','BN'=>'Benevento','BG'=>'Bergamo','BI'=>'Biella','BO'=>'Bologna','BZ'=>'Bolzano','BS'=>'Brescia','BR'=>'Brindisi','CA'=>'Cagliari','CL'=>'Caltanissetta','CB'=>'Campobasso','CI'=>'Carbonia-Iglesias','CE'=>'Caserta','CT'=>'Catania','CZ'=>'Catanzaro','CH'=>'Chieti','CO'=>'Como','CS'=>'Cosenza','CR'=>'Cremona','KR'=>'Crotone','CN'=>'Cuneo','EN'=>'Enna','FM'=>'Fermo','FE'=>'Ferrara','FI'=>'Firenze','FG'=>'Foggia','FC'=>'Forlì-Cesena','FR'=>'Frosinone','GE'=>'Genova','GO'=>'Gorizia','GR'=>'Grosseto','IM'=>'Imperia','IS'=>'Isernia','SP'=>'La Spezia','AQ'=>'L\'Aquila','LT'=>'Latina','LE'=>'Lecce','LC'=>'Lecco','LI'=>'Livorno','LO'=>'Lodi','LU'=>'Lucca','MC'=>'Macerata','MN'=>'Mantova','MS'=>'Massa-Carrara','MT'=>'Matera','ME'=>'Messina','MI'=>'Milano','MO'=>'Modena','MB'=>'Monza e della Brianza','NA'=>'Napoli','NO'=>'Novara','NU'=>'Nuoro','OT'=>'Olbia-Tempio','OR'=>'Oristano','PD'=>'Padova','PA'=>'Palermo','PR'=>'Parma','PV'=>'Pavia','PG'=>'Perugia','PU'=>'Pesaro e Urbino','PE'=>'Pescara','PC'=>'Piacenza','PI'=>'Pisa','PT'=>'Pistoia','PN'=>'Pordenone','PZ'=>'Potenza','PO'=>'Prato','RG'=>'Ragusa','RA'=>'Ravenna','RC'=>'Reggio Calabria','RE'=>'Reggio Emilia','RI'=>'Rieti','RN'=>'Rimini','RM'=>'Roma','RO'=>'Rovigo','SA'=>'Salerno','VS'=>'Medio Campidano','SS'=>'Sassari','SV'=>'Savona','SI'=>'Siena','SR'=>'Siracusa','SO'=>'Sondrio','TA'=>'Taranto','TE'=>'Teramo','TR'=>'Terni','TO'=>'Torino','OG'=>'Ogliastra','TP'=>'Trapani','TN'=>'Trento','TV'=>'Treviso','TS'=>'Trieste','UD'=>'Udine','VA'=>'Varese','VE'=>'Venezia','VB'=>'Verbano-Cusio-Ossola','VC'=>'Vercelli','VR'=>'Verona','VV'=>'Vibo Valentia','VI'=>'Vicenza','VT'=>'Viterbo',);
              
        date_default_timezone_set('Europe/Rome');
        $this->annoCorrente = intval(date('Y'));
        $this->meseCorrente = date('m');
        $this->giornoCorrente = intval(date('d'));
                
        $date = new \DateTime($this->annoCorrente.'-'.$this->meseCorrente.'-'.$this->giornoCorrente);
        $this->settimanaCorrente = $date->format("W");
    }
    
    
    /***********************************************************/
    /*** FUNZIONI PER LA GESTIONE DELL'UTENTE WP ***/
    /***********************************************************/
    
    
    /**
     * La funzione si occupa di restituire un form di salvataggio dell'utente Wp
     * @param int|null $idWp
     * @return string
     */
    protected function getUtenteWpFormFields(int|null $idWp=null): string{
        $uWp = new UtenteWp();
        $html = '';
        $html .= '<fieldset class="form-group border p-3"><legend class="w-auto px-1">Campi Utente WP</legend>';   
        if($idWp != null  && $idWp != 0){
            //ho dei parametri, si tratta di un aggiornamento
            $uWp->get($idWp);
            //ID
            $html .= $this->printInput(Modello::FLOAT(), Campo::NASCOSTO(), FRM_UWP.FRM_ID, '', Richiesto::NO(), $uWp->getID());
            //Nome
            $html .= $this->printInput(Modello::FLOAT(), Campo::TESTO(), FRM_UWP.FRM_NOME, LBL_NOME, Richiesto::NO(), $uWp->getNome());
            //Cognome
            $html .= $this->printInput(Modello::FLOAT(), Campo::TESTO(), FRM_UWP.FRM_COGNOME, LBL_COGNOME, Richiesto::NO(), $uWp->getCognome());
            //Email (se è già stata inserita non può cambiare)
            if($uWp->getEmail() != '' && $uWp->getEmail() != null){
                $html .= $this->printInput(Modello::FLOAT(), Campo::EMAIL(), FRM_UWP.FRM_EMAIL, LBL_EMAIL, Richiesto::NO(), $uWp->getEmail(), Disabilitato::SI());
            }
            else{
                $html .= $this->printInput(Modello::FLOAT(), Campo::EMAIL(), FRM_UWP.FRM_EMAIL, LBL_EMAIL, Richiesto::NO(), $uWp->getEmail());
            }
            //Password (se lasciata vuota, il sistema genera una password randomica)
            $html .= $this->printInput(modello::FLOAT(), Campo::PASSWORD(), FRM_UWP.FRM_PSW, LBL_PASSWORD, Richiesto::NO(), $uWp->getPassword());
           
        }
        else{
            //non ho dei parametri, si tratta di un salvataggio
            //Nome
            $html .= $this->printInput(Modello::FLOAT(), Campo::TESTO(), FRM_UWP.FRM_NOME, LBL_NOME);
            //Cognome
            $html .= $this->printInput(Modello::FLOAT(), Campo::TESTO(), FRM_UWP.FRM_COGNOME, LBL_COGNOME);
            //Email
            $html .= $this->printInput(Modello::FLOAT(), Campo::EMAIL(), FRM_UWP.FRM_EMAIL, LBL_EMAIL);
            //Password (se lasciata vuota, il sistema genera una password randomica)
            $html .= $this->printInput(modello::FLOAT(), Campo::PASSWORD(), FRM_UWP.FRM_PSW, LBL_PASSWORD, Richiesto::NO());            
        }
        
        $html .= '</fieldset>';
        return $html;
    }
    
    /**
     * La funzione fa un controllo sui campi utente passati e restituisce un oggetto
     * Utente WP
     * @param string $email
     * @return UtenteWp
     */
    protected function utenteWpCheckFields(string $email=null) :UtenteWp{
        //devo controllare l'inserimento dei dati:
        //Nome, Cognome, Email, Password       
        $uWp = new UtenteWp();        
          
        //ID: not required
        if($this->check(Campo::TESTO(), FRM_UWP.FRM_ID,'') !== false){
            $uWp->setID($this->check(Campo::TESTO(), FRM_UWP.FRM_ID,''));
        }        
        //Nome: not required
        if($this->check(Campo::TESTO(), FRM_UWP.FRM_NOME, LBL_NOME) !== false){
            $uWp->setNome($this->check(Campo::TESTO(), FRM_UWP.FRM_NOME, LBL_NOME));
        }
        //Cognome: not required
        if($this->check(Campo::TESTO(), FRM_UWP.FRM_COGNOME, LBL_COGNOME) !== false){
            $uWp->setCognome($this->check(Campo::TESTO(), FRM_UWP.FRM_COGNOME, LBL_COGNOME));
        }
        //Email: not required
        if($email == null){
            if($this->check(campo::EMAIL(), FRM_UWP.FRM_EMAIL, LBL_EMAIL) !== false){
                $uWp->setEmail($this->check(campo::EMAIL(), FRM_UWP.FRM_EMAIL, LBL_EMAIL));
            }
        }
        else{
            $uWp->setEmail($email);
        }
        //Password: not required
        if($this->check(Campo::PASSWORD(), FRM_UWP.FRM_PSW, LBL_PASSWORD) !== false){
            $uWp->setPassword($this->check(Campo::PASSWORD(), FRM_UWP.FRM_PSW, LBL_PASSWORD));
        }
        
        //Imposto il nicename
        $uWp->setNicename($uWp->getNome().' '.$uWp->getCognome());
                
        return $uWp;
    }
    
    /***********************************************************/
    /*** FINE FUNZIONI PER LA GESTIONE DELL'UTENTE WP ***/
    /***********************************************************/
    
    
    
    /***********************************************************/
    /*** AGGIORNAMENTO BLOCCHI CON LA CDN DI BOOTSTRAP v.5.3 ***/
    /***********************************************************/
   
    /**
     * Aggiunge un container al dom
     * @param string $content
     * @param string $typeContainer
     * @return string
     */
    protected function addContainer(string $content, string $typeContainer = ''): string{
        $classFluid = '';
        if($typeContainer != ''){
            $classFluid = '-'.$typeContainer;
        }
        $html = '<div class="container'.$classFluid.'">';
        $html .= $content;
        $html .= '</div>';
        return $html;
    } 

    /**
     * Aggiunge u
     * @param string $name
     * @param string $content
     * @param bool $files
     * @return string
     */
    protected function saveForm(string $name, string $content, bool $files=false): string{
        $html = '';
        $add = '';
        if($files == true){
            $add = 'enctype="multipart/form-data"';
        }        
        $html .= '<form role="form" action="'.curPageURL().'" method="POST" name="'.FRM_ADD.$name.'" '.$add.' class="g-3 form-floating needs-validation">';
        $html .= $content; 
        $html .= $this->submitButton($name.FRM_SAVE, 'SALVA');
        $html .= '</form>';
        return $html;
    }
    
    /**
     * Restituisce un form dettaglio passando il contenuto come parametro
     * @param string $name
     * @param string $content
     * @param bool $files
     * @return string
     */
    protected function detailForm(string $name, string $content, bool $files=false): string{
        $html = '';
        $add = '';
        if($files == true){
            $add = 'enctype="multipart/form-data"';
        }     
        $html .= '<form role="form" action="'.curPageURL().'" method="POST" name="'.FRM_DETAILS.$name.'" '.$add.' class="g-3 form-floating needs-validation">';
        $html .= $content; 
        
        /** Stampo i bottoni di aggiornamento e cancellazione **/
        $html .= '<div class="col-12">';
        $html .= $this->getButton($name.FRM_UPDATE, 'AGGIORNA');
        $html .= $this->getButton($name.FRM_DELETE, 'ELIMINA');        
        $html .= '</div>';
        $html .= '</form>';
        
        return $html;
    }
    
    protected function getButton(string $nameFiled, string $value ):string{
        return '<button class="btn btn-primary" type="submit" name="'.$nameFiled.'">'.$value.'</button>';
    }
    
    protected function submitButton(string $nameFiled, string $value ): string{
        $html = '<div class="col-xs-12 col-sm-3">';
        $html .= '<button class="btn btn-primary" type="submit" name="'.$nameFiled.'">'.$value.'</button>';
        $html .= '</div>';
        return $html;
    }
   
    protected function linkButton(string $testo, string $link) : string{
        return '<a class="btn btn-outline-primary" href="'.$link.'" role="button">'.$testo.'</a>';
    }
    
    private function verifyField(string|int|array|null $value, string $name): string|int|array|null{
        $result = null;
        if($value == null){
            if(isset($_POST[$name])){
                if(!is_array($_POST[$name])){
                    $result = stripslashes($_POST[$name]);
                }
                else{
                    $result = $_POST[$name];
                }
            }  
        }
        else{
            if(!is_array($value)){
                $result = stripslashes($value);
            }
            else{
                    $result = $value;
                }
        }
        return $result;
    }
    
    /**
     * La funzione restituisce la stampa di un oggetto html input (definito dal type)
     * @param string $modello
     * @param string $campo
     * @param string $name
     * @param string $label
     * @param string $required
     * @param string $value
     * @param string $disabled
     * @return string
     */
    protected function printInput(string $modello, string $campo, string $name, string $label, string $required='', string|null|int $value=null, string $disabled=''): string{
        $html = ''; 
        $value = $this->verifyField($value, $name);
        
        //Print Input si compone di tanti elementi a seconda del modello e del type.
        //modello: float e due-colonne
        //type: hidden, price, text, email, tel
        
        if($campo == Campo::NASCOSTO()){
            $html .= '<input class="input-hidden" type="hidden" name="'.$name.'" value="'.$value.'" />';
            return $html;
        }
        
        if($modello == Modello::FLOAT()){
            $html .= $this->getFloatLayout($campo, $name, $label, $required, $value, $disabled);
        }
        else if($modello == Modello::DUE_COLONNE()){
            $html .= $this->get2ColonneLayout($campo, $name, $label, $required, $value, $disabled);
        }
       
        return $html;
    }
    
    private function getFloatLayout(string $campo, string $name, string $label, string $required='', string $value=null, string $disabled='' ): string {
        $html = '';
        $input = '';
        $classDiv1 = 'form-floating mb-3';
        if($campo == Campo::PREZZO()){
            $classDiv1 = 'input-group mb-3';
            $input .= '<div class="form-floating">'
                        . '<input type="number" min="0" step="0.01" class="form-control" name="'.$name.'" id="'.$name.'" value="'.$value.'" placeholder="'.$value.'" '.$required.' '.$disabled.'>'
                        . '<label for="'.$name.'">'.$label.'</label>'
                    . '</div>'
                    . '<span class="input-group-text">€</span>';
        }
        else if($campo == Campo::TESTO() || $campo == Campo::EMAIL() || $campo == Campo::TELEFONO()){             
            $input .= '<input type="'.$campo.'" class="form-control" name="'.$name.'" id="'.$name.'" value="'.$value.'" placeholder="'.$value.'" '.$required.' '.$disabled.'>'
                        . '<label for="'.$name.'">'.$label.'</label>';
        } 
        else if($campo == Campo::PASSWORD()){                                    
            $input .=  '<input name="'.$name.'" type="password" value="" class="input form-control" id="'.$campo.'" placeholder="'.$value.'" '.$required.' aria-label="password" aria-describedby="basic-addon1" />';
            $input .= '<label class="form-label" for="'.$name.'">'.$label.'</label>';
            $input .=  '<div class="input-group-append">
                            <span class="input-group-text show-hide" onclick="password_show_hide();">
                              <i class="fas fa-eye" id="show_eye"></i>
                              <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                            </span>
                          </div>';
            
            //$input .= '<input type="'.$type.'" class="form-control" name="'.$name.'" id="'.$name.'" value="'.$value.'" placeholder="'.$value.'" '.$required.' '.$disabled.'><i class="bi bi-eye-slash" id="togglePassword"></i>'                       
            
        }
        else if($campo == Campo::AREA_DI_TESTO()){
            $input .= '<textarea rows="4" style="height:100%;" class="form-control" name="'.$name.'" id="'.$name.'" '.$required.' '.$disabled.'>'.$value.'</textarea>'
                    . '<label for="'.$name.'">'.$label.'</label>';
        }
        else if($campo == Campo::FILE()){
            $input .= '<label style="display:block" for="'.$name.'" class="form-label">'.$label.'</label>'
                    . '<input class="input form-control form-control-lg" id="'.$name.'" value="'.$value.'" name="'.$name.'" type="file" '.$required.' '.$disabled.'>';
        }
        else if($campo == Campo::IMMAGINE()){
            $immagine = '';
            if($value != null){
                $immagine = '<img src="'.$value.'" style="max-width:150px;">';       
                $input .= '<input class="input-hidden" type="hidden" name="'.$name.'-old" value="'.$value.'" />';
            }
            $input .= '<p><strong>'.$label.'</strong></p>'                    
                    . '<div class="container-immagine">'
                    . '<div style="display:inline-block; width:65%"><input class="input form-control form-control-lg" id="'.$name.'" value="'.$value.'" name="'.$name.'" type="file" '.$required.' '.$disabled.'></div>'
                    . '<div style="display:inline-block; width:30%; margin-left:5%; text-align:center; border:1px solid #999; padding:15px;">'.$immagine.'</div>'
                    . '</div>';
        }
        else if($campo == Campo::EDITOR()){
            ob_start();
            wp_editor($value, $name);
            $editorContent = ob_get_clean();
            $input .= $editorContent;
            $input .= '<label for="'.$name.'">'.$label.'</label>';            
        } 
                
        $html .= '<div class="'.$classDiv1.'">';
        $html .=    $input;
        $html .= '</div>';
        
        return $html;
    }
    
    private function get2ColonneLayout(string $campo, string $name, string $label, string $required='', string|array $value=null, string $disabled='' ): string {
        $html = '';  
        $html .= '<div class="row mb-3">';
        $html .=     '<label for="'.$name.'" class="col-sm-3 col-form-label form-label">'.$label.'</label>';
        $html .=      '<div class="col-sm-9">';
        if($campo == Campo::PREZZO()){
            $html .=        '<div class="input-group">';
            $html .=         '<input type="number" min="0" step="0.01" class="form-control" name="'.$name.'" value="'.$value.'" id="'.$name.'" '.$required.' '.$disabled.'>';
            $html .=         '<span class="input-group-text" id="basic-addon1">€</span>';
            $html .=        '</div>';
        }
        else if($campo == Campo::TESTO() || $campo == Campo::EMAIL() || $campo == Campo::TELEFONO()){    
            $html .=         '<input type="'.$campo.'" class="form-control" name="'.$name.'" value="'.$value.'" id="'.$name.'" '.$required.' '.$disabled.'>';
        }
        else if($campo == Campo::PASSWORD()){
         
            $html .=  '<input name="'.$name.'" type="password" value="" class="input form-control" id="'.$campo.'" placeholder="'.$value.'" required="true" aria-label="password" aria-describedby="basic-addon1" />';            
            $html .=  '<div class="input-group-append">
                            <span class="input-group-text show-hide" onclick="password_show_hide();">
                              <i class="fas fa-eye" id="show_eye"></i>
                              <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                            </span>
                          </div>';           
        }
        else if($campo == Campo::AREA_DI_TESTO()){
            $html .= '<textarea rows="4" style="height:100%;" class="form-control" name="'.$name.'" id="'.$name.'" '.$required.' '.$disabled.'>'.$value.'</textarea>';
        }
        else if($campo == Campo::FILE()){
            $html .= '<input class="input form-control form-control-lg" id="'.$name.'" name="'.$name.'" value="'.$value.'" type="file" '.$required.' '.$disabled.'>';
            $html .= '<p>'.$value.'</p>';
        }
        else if($campo == Campo::EDITOR()){
            ob_start();
            wp_editor($value, $name);
            $editorContent = ob_get_clean();
            $html .= $editorContent;
        }
        
        $html .=     '</div>';        
        $html .= '</div>';
        
        return $html;
    }
    
   
    protected function printSelect(string $modello, string $typeSelect, string $name, string $label, array $array, string $required='', string|null|int|array $value=null, string $disabled=''): string{
        //type deve essere o vuoto o con multiple
        $html = '';                
        $value = $this->verifyField($value, $name);      
          
        if($modello == Modello::FLOAT()){
            $html .= '<div class="form-floating mb-3">';            
            $html .=    $this->getSelect($typeSelect, $name, $label, $array, $required, $disabled, $value);            
            $html .=    '<label for="'.$name.'">'.$label.'</label>';            
            $html .= '</div>';
        }
        else if($modello == Modello::DUE_COLONNE()){
            $html .= '<div class="row mb-3">';
            $html .=     '<label for="'.$name.'" class="col-sm-3 col-form-label form-label">'.$label.'</label>';
            $html .=     '<div class="col-sm-9">'; 
            $html .=        $this->getSelect($typeSelect, $name, $label, $array, $required, $disabled, $value);            
            $html .=     '</div>';
            $html .= '</div>';
        }                
        return $html;
    }
    
    private function getSelect(string $typeSelect, string $name, string $label, array $array, string $required, string $disabled, string|int|array|null $value): string{
        //type indica se si tratta di un multiselect o un select normale;
        $html = '';
        $multiple = '';
        $script = '<script type="text/javascript">';
        $script .= ' jQuery(document).ready(function() {';
        $script .= '  jQuery(".multiselect-'.$name.'").multipleSelect({';
        $script .= '   filter: true  ';
        $script .= '  });';
        $script .= ' });';
        $script .= '</script>';
        
        $class = 'class="form-select"';
        
        if($typeSelect == 'multiple'){
            $class = ' class="multiselect multiselect-'.$name.'" multiple="multiple" size="'. count($array) .'" ';
            $script .= '';
            $name .= '[]';
        }
        
        if($disabled == null){
            $html .= '<select '.$class.' id="'.$name.'" name="'.$name.'" aria-label="'.$label.'" '.$required.' '.$disabled.'>';
            //aggiungo il prino campo vuoto
            $html .=    '<option value=""></option>';
            foreach($array as $k => $v){
                if($value == $k){
                    $html .= '<option value="'.$k.'" selected="selected" >'.$v.'</option>';
                }
                else{
                    $html .= '<option value="'.$k.'">'.$v.'</option>';
                }
            } 
            $html .= '</select>';
            $html .= $script;    
        }
        else{
            $selected = '';
            foreach($value as $item){
                $selected .= $array[$item].', ';
            }
            $html .= '<input type="text" disabled value="'.$selected.'">';
        }           
        return $html;
    }
    
    protected function printCheckBox(string $modello, string $name, string $label, array $array, int|string|array|null $value=null): string{
        $html = '';
        $value = $this->verifyField($value, $name);
        
        if($modello == Modello::FLOAT()){
            $html .= '<div class="form-floating mb-3">';            
            $html .=    $this->getCheckBox($name, $label, $array, $value);                
            $html .=    '<label for="'.$name.'">'.$label.'</label>';            
            $html .= '</div>';
        }
        else if($modello == Modello::DUE_COLONNE()){
            $html .= '<div class="row mb-3">';
            $html .=     '<label for="'.$name.'" class="col-sm-3 col-form-label form-label">'.$label.'</label>';
            $html .=     '<div class="col-sm-9">'; 
            $html .=        $this->getCheckBox($name, $label, $array, $value);                
            $html .=     '</div>';
            $html .= '</div>';
        }
        
        return $html;
    }
    
    private function getCheckBox(string $name, string $label, array $array, int|string|array|null $value): string{
        $html = '';
        $html .= '<div class="form-check">';
        foreach($array as $k => $v){
            $checked = '';
           
            if(is_array($value)){
                if(in_array($k, $value)){
                    $checked = 'checked ';
                }
            }
            else{
                if($value == $k){
                    $checked = 'checked ';
                }   
            }
            
            $html .= '<div class="single-check '.$k.'">';
            $html .= '  <input class="form-check-input '.$k.'" type="checkbox" name="'.$name.'[]" value="'.$k.'" '.$checked.' >';
            $html .= '  <label class="form-check-label '.$k.'">'.$v.'</label>';
            $html .= '</div>';
        }        
        $html .= '</div>';
        return $html;
    }
       
   //Error Message
    protected function errorBox(string $message): string{
        $html = '<div class="alert alert-danger">';
        $html .=     '<strong>Errore!</strong> '.$message;
        $html .= '</div>';
        return $html;
    }
   
       
    /*************** FUNZIONI CHECK **********/
    
    protected function check(string $campo, string $name, string $label, bool $required=false): bool|string|array{
    //I type sono: text, select, file, multiple-select, date, textarea, immagine
        $result = false;
        switch($campo){
            case Campo::TESTO():
            case Campo::SELECT():
            case Campo::EMAIL():
            case Campo::TELEFONO():
            case Campo::AREA_DI_TESTO():
            case Campo::PREZZO():
            //case Campo::CHECKBOX():
                if($required){
                    $result = $this->checkRequiredSingleField($name, $label);
                }
                else{                    
                    $result = $this->checkSingleField($name);
                }
                break;
            case Campo::FILE():
                $temp = $this->checkUploadFileField($name);
                if($temp != null){
                    $result = $temp['url'];
                }
                else{
                    $result = '';
                }
                break;
            case Campo::IMMAGINE():
                //verifico se è stata caricata una nuova immagine
                $temp = $this->checkUploadFileField($name);
                if($temp != null){
                    $result = $temp['url'];
                }
                else{
                    //se non c'è nulla utilizzo il vecchio valore dell'immagine
                    $result = $this->checkSingleField($name.'-old');
                }
                break;                
            case 'multiple-select':
            case Campo::CHECKBOX():
                //restituisce un array
                $result = $this->checkMultipleSelectField($name);                 
                break;
            case Campo::DATA():
                $result = $this->checkDateField($name, $label);
                break;
            default:
                break;
        }
        return $result;       
    }
    
    /**
     * La funzione controlla il valore di un campo obbligatorio e lo restituisce in caso di successo, false in caso di errore
     * @param type $nameField
     * @return boolean
     */
    protected function checkRequiredSingleField($nameField, $labelField){
       
        if(isset($_POST[$nameField]) && trim($_POST[$nameField]) != ''){
            return trim($_POST[$nameField]);
        }
        $this->printErrorBoxMessage('Campo '.$labelField.' mancante o non corretto.');
        return false;        
    }
    
    /**
     * La funzione controlla il valore di un campo e lo restitusce se questo è stato compilato
     * @param type $nameField
     * @return boolean
     */
    protected function checkSingleField($nameField){
        if(isset($_POST[$nameField]) && trim($_POST[$nameField]) != ''){            
            return trim($_POST[$nameField]);
        }
        return false;
    }
    
    /**
     * La funzione controlla il file multimediale caricato e lo salva nella cartella uploads di wordpress
     * @param type $nameField
     * @return type
     */
    protected function checkUploadFileField($nameField){       
        $upload = null;
        if(isset($_FILES[$nameField])){
           if($_FILES[$nameField]['error'] == 0){
               //salvo il file su wp
               $upload = wp_upload_bits($_FILES[$nameField]["name"], null, file_get_contents($_FILES[$nameField]["tmp_name"]));
           }           
        }
        return $upload;
    }
    
    /**
     * La funzione controlla un multiple select field o una checkbox e restituisce i campi in un array
     * @param type $nameField
     * @return array
     */
    protected function checkMultipleSelectField($nameField){  
        //print_r($_POST[$nameField]);
        if(isset($_POST[$nameField]) && count($_POST[$nameField]) > 0){
            $result = array();
            foreach($_POST[$nameField] as $item){
                array_push($result, $item);
            }
            return $result;
        }
        return false;
        
    }
    
    /**
     * La funzione controlla il valore di una data e lo restituisce se questo è stato compilato
     * @param type $nameField
     * @param type $labelField
     * @return boolean
     */
    protected function checkDateField($nameField, $labelField){
        if(isset($_POST[$nameField.'-d']) && isset($_POST[$nameField.'-m']) && isset($_POST[$nameField.'-y'])){
           //conversione in timestamp
            $d = "";
            if(intval($_POST[$nameField.'-d']) < 10){
                $d = '0'.$_POST[$nameField.'-d'];
            }
            else{
                 $d = ''.$_POST[$nameField.'-d'];
            }
            $m = $_POST[$nameField.'-m'];
            $y = $_POST[$nameField.'-y'];
            
            //$dtime = DateTime::createFromFormat("d/m/Y H:i", $d."/".$m."/".$y." 00:00");
            $timestamp = date($y.'-'.$m.'-'.$d);
            
            return $timestamp;
        }
        return false;
    }
    
    
    /*************** FINE FUNZIONI CHECK **********/
    
    
    protected function printTable(string $name, array $header, array $rows): string{
        $html = '';
        
        $html .= '<div class="table-responsive-sm">';
        $html .= '<table id="sorting-table-'.$name.'" class="table table-hover table-striped table-bordered">';
        
        $html .=    '<thead>';
        $html .=        '<tr>';        
        foreach($header as $th){
            $html.=         '<th class="th-sm">'.$th.'</th>';
        }        
        $html .=        '</tr>';
        $html .=    '</thead>';
        
        $html .=    '<tbody>';        
        $html .= $this->printRows($rows);        
        $html .=    '</tbody>';
        
        /**
        $html .=    '</tfoot>';
        $html .=        '<tr>';    
        foreach($header as $th){
            $html.=         '<th>'.$th.'</th>';
        }
        $html .=        '</tr>';
        $html .=    '</tfoot>';
        */
        
        $html .= '</table>';               
        $html .= '</div>';
        
        return $html;
    }
    
    private function printRows(array $rows): string{
        $html = '';
        foreach($rows as $columns){
            $html .= '<tr>';
            foreach($columns as $column){
                $html .= '<td>'.$column.'</td>';
            }            
            $html .= '</tr>';
        }
        
        
        return $html;
    }
   
    private function addAttribute(string $attName, string $attValue):string{        
        return ' '.$attName.'="'.$attValue.'"';        
    }
    
    private function addClass(string|null $value):string{        
        $html = '';
        if($value != null){
            $html .= $this->addAttribute('class', $value);
        }
        return $html;
    }
    
    private function addHref(string|null $value):string{
        $html = '';
        if($value != null){
            $html .= $this->addAttribute('href', $value);
        }
        return $html;
    }  
    
    private function addTarget(string|null $value): string{
        $html = '';
        if($value != null){
            $html .= $this->addAttribute('target', $value);
        }
        return $html;
    }
    
    private function addData(string|null $dataName, string|null $dataValue):string{
        $html = '';
        if($dataName != null && $dataValue != null){
            $html .= $this->addAttribute('data-'.$dataName, $dataValue);
        }
        return $html;
    }
    
    protected function printTitoloTabella(string $titolo): string{
        return $this->printTitolo('h2', $titolo);
    }    
    
    protected function printTitoloPagina(string $titolo):string{
        return $this->printTitolo('h2', $titolo, 'titolo');
    }
    
    public function printTitolo(string $tag, string $titolo, string $classe=null):string{
        $class = $this->addClass($classe);
        return '<'.$tag.$class.'>'.$titolo.'</'.$tag.'>';
    }
    
    protected function printUrl(string $label, string $url=null, string $class=null, string $target=null): string{
        $html = '';
        $html .= '<a';
        $html .= $this->addClass($class);
        $html .= $this->addHref($url); 
        $html .= $this->addTarget($target);
        $html .= '>'.$label.'</a>';        
        return $html;
    }
    
    protected function printAlert(string $label):string{
        return '<div class="alert alert-secondary" role="alert">'.$label.'</div>';
    }
    
    protected function printDiv(string $content, string $class=null, string $dataName=null, string $dataValue=null):string{
        $html = '';
        $html .= '<div';
        $html .= $this->addClass($class);
        $html .= $this->addData($dataName, $dataValue);        
        $html .= '>'.$content.'</div>';        
        return $html;
    }
    
    protected function printDataNumDiv(string $content, string $dataValue, string $class=null):string{
        return $this->printDiv($content, $class, 'num', $dataValue);
    }
    
    protected function strongText(string $label):string{
        return '<strong>'.$label.'</strong>';
    }
    
    protected function printImage(string $url, string $class=null):string{
        $class = '';
        if($class != null){
            $class = 'class="'.$class.'"';
        }
        return '<img src="'.$url.'" '.$class.' />';
    }
    
    /**
     * La funzione stampa una sezione a TAB passando l'id della sezione e il contenuto suddiviso in ID, Prefisso, Titolo e Contenuto
     * @param string $idTab
     * @param array $dati
     * @return string
     */
    protected function printTabSection(string $idTab, array $dati):string{
        $html = '';
        
        //$dati è un array che contiene un ulteriore array $data:        
        //1. Prefisso del contenuto $data['prefisso']
        //2. Titolo del menu (uguale per tutti in italiano) $data['titolo]
        //3. Contenuto $data['contenuto']
        
        //Stampo i tabs
        $html .= '<ul class="nav nav-tabs" id="'.$idTab.'" role="tablist">';
        $count = 0;
        foreach ($dati as $data){
            $active = '';
            $selected = 'false';
            if($count == 0){
                $active = 'active';
                $selected = 'true';
            }
            $html .= '<li class="nav-item" role="presentation">';
            $html .=    '<button class="nav-link '.$active.'" id="'.$data['prefisso'].'-tab" data-bs-toggle="tab" data-bs-target="#'.$data['prefisso'].'-tab-pane" type="button" role="tab" aria-controls="'.$data['prefisso'].'-tab-pane" aria-selected="'.$selected.'">';
            $html .=        $data['titolo'];
            $html .=    '</button>';
            $html .= '</li>';
            $count++;
        }
        $html .= '</ul>';
        
        //Stampo i content
        $html .= '<div class="tab-content" id="'.$idTab.'Content">';
        
        $count = 0;
        foreach ($dati as $data){
            $active = '';
            if($count == 0){
                $active = 'show active';
            }
            $html .= '<div class="tab-pane fade '.$active.'" id="'.$data['prefisso'].'-tab-pane" role="tabpanel" aria-labelledby="'.$data['prefisso'].'-tab" tabindex="0">';
            $html .= $data['contenuto'];
            $html .= '</div>';            
            $count++;
        }
        $html .= '</div>';
        
        return $html;
    }
    


    /***********************************************************/
    /*** FINE AGGIORNAMENTO BLOCCHI CON LA CDN DI BOOTSTRAP v.5.3 ***/
    /***********************************************************/

    /**
     * La funzione stampa per comodità l'apertura del tag form
     * @param type $name
     */
    protected function printStartAddForm($name, $files=false){
        $html = '';
        if($files == true){        
            $html = 'enctype="multipart/form-data"';
        }
    ?>
        <form class="form-horizontal" role="form" action="<?php echo curPageURL() ?>" name="<?php echo FRM_ADD.$name ?>" method="POST" <?php echo $html ?> >   
            ciao
    <?php
    }
    
    /**
     * La funzione stampa per comodita il bottone submit e la chiusura del tag form
     * @param type $name
     */
    protected function printEndAddForm($name){
    ?>
            <?php $this->printSubmitFormField(FRM_SAVE.$name, 'SALVA') ?>
        </form>
    <?php
    }
    
    protected function printStartDetailsForm($name, $files=false){
        $html = '';
        if($files == true){        
            $html = 'enctype="multipart/form-data"';
        }
    ?>
        <form class="form-horizontal" role="form" action="<?php echo curPageURL() ?>" name="<?php echo FRM_DETAILS.$name ?>" method="POST" <?php echo $html ?> >   
    <?php
    }
    
    protected function printEndDetailsForm($name, $disabled = null){
    ?>
            <?php $this->printUpdateDettaglio($name) ?>
            <?php if($disabled == null): ?>                                
                <?php $this->printDeleteDettaglio($name) ?>               
            <?php endif; ?>
        </form>
    <?php    
    }
    
    protected function printStartSearchForm($name){
    ?>
        <form class="form-horizontal search-box" role="form" action="<?php echo curPageURL() ?>" name="<?php echo FRM_SEARCH.$name ?>" method="POST">
    <?php
    }
    
    protected function printEndSearchForm(){
        $this->printSubmitFormField(FRM_SEARCH_SUBMIT, 'RICERCA');
        $this->printSubmitFormField(FRM_SEARCH_RESET, 'PULISCI');
    ?>
        </form>
    <?php
    }
    
    
    /**
     * Funzione che stampa secondo canoni bootstrap un input text
     * @param type $nameField
     * @param type $label
     */
    protected function printTextFormField($nameField, $label, $required=false, $value=null, $disabled = null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }
        $dis = '';
        if($disabled == true){
            $dis = 'disabled';
        }
        
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">            
                <input class="form-control" type="text" id="<?php echo $nameField ?>" name="<?php echo $nameField ?>" value="<?php echo $value ?>" <?php echo $optRequired.' '.$dis ?> />
            </div>
        </div>
    <?php  
    }
    
    protected function printPasswordFormField($nameField, $label, $required=false, $value=null, $disabled = null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }
        $dis = '';
        if($disabled == true){
            $dis = 'disabled';
        }
        
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">            
                <input class="form-control" type="password" id="<?php echo $nameField ?>" name="<?php echo $nameField ?>" value="<?php echo $value ?>" <?php echo $optRequired.' '.$dis ?> />
            </div>
        </div>
    <?php  
    }
    
    protected function printSuggestTextFormField($nameField, $label, $required=false, $value=null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }
        
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">            
                <input class="form-control" type="text" id="<?php echo $nameField ?>" name="<?php echo $nameField ?>" value="<?php echo $value ?>" <?php echo $optRequired ?> />
                <div class="suggerimenti"></div>
            </div>
        </div>
    <?php  
    }
    
    protected function printCheckBoxInlineFormField($nameField, $label, $array, $value=null){
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }
    ?>    
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>"> 
                <?php foreach($array as $k => $v): ?>
                    <?php if ($value == $k): ?>
                        <div class="checkbox"><input name="<?php echo $nameField ?>" type="checkbox" value="<?php echo $k ?>" checked><?php echo $v ?></div>
                    <?php else: ?>                 
                        <div class="checkbox"><input name="<?php echo $nameField ?>" type="checkbox" value="<?php echo $k ?>"><?php echo $v ?></div>                        
                    <?php endif; ?>
                
                <?php endforeach; ?>
            </div>
        </div>
    <?php    
    }
    
    
    /**
     * Funzione che stampa una input text disabilitata
     * @param type $nameField
     * @param type $label
     * @param type $value
     */
    protected function printDisabledTextFormField($nameField, $label, $value){       
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">            
                <input class="form-control" type="text" id="<?php echo $nameField ?>" name="<?php echo $nameField ?>" value="<?php echo $value ?>" disabled />
            </div>
            <div class="clear"></div>
        </div>
    <?php  
    }
    
    
          
    /**
     * Funzione che stampa secondo i canoni bootstrap una textarea
     * @param type $nameField
     * @param type $label
     */
    protected function printTextAreaFormField($nameField, $label, $required=false, $value=null, $disabled = null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }
        $dis = '';
        if($disabled == true){
            $dis = 'disabled';
        }
        
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">    
                <textarea class="form-control" id="<?php echo $nameField ?>" name="<?php echo $nameField ?>" value="" <?php echo $optRequired.' '.$dis ?>><?php echo $value ?></textarea>           
            </div>
        </div>
    <?php      
        
    }
    
    protected function printDisabledTextAreaFormField($nameField, $label, $value){
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">    
                <textarea class="form-control" id="<?php echo $nameField ?>" name="<?php echo $nameField ?>" value="" disabled ><?php echo $value ?></textarea>           
            </div>
        </div>
    <?php       
    }
    
    protected function printNumberFormField($nameField, $label, $required=false, $value=null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }  
       
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">            
                <input class="form-control" type="number" step="any" id="<?php echo $nameField ?>" name="<?php echo $nameField ?>" value="<?php echo $value ?>" <?php echo $optRequired ?> />
            </div>
        </div>
    <?php     
    }
    
    
    protected function printNumberFormFieldAddOn($addOn, $nameField, $label, $required=false, $value=null, $disabled = null ){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }  
        $dis = '';
        if($disabled == true){
            $dis = 'disabled';
        }
       
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="input-group <?php echo COLONNA_CONTENUTO ?>">
                <span class="input-group-addon" id="basic-addon1"><?php echo $addOn ?></span>
                <input class="form-control" aria-describedby="basic-addon1" type="number" step="any" id="<?php echo $nameField ?>" name="<?php echo $nameField ?>" value="<?php echo $value ?>" <?php echo $optRequired.' '.$dis ?> />
            </div>
        </div>
    <?php     
    }
    
    /**
     * Funzione che stampa secondo i canoni bootstrap una input email
     * @param type $nameField
     * @param type $label
     */
    protected function printEmailFormField($nameField, $label, $required=false, $value=null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        if($value==null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">            
                <input class="form-control" type="email" id="<?php echo $nameField ?>" name="<?php echo $nameField ?>" value="<?php echo $value ?>" <?php echo $optRequired ?> />
            </div>
        </div>
    <?php      
    }
    
    
    /**
     * Funzione che stampa secondo i canoni di bootstrap una input file upload
     * @param type $nameField
     * @param type $label
     * @param type $required
     */
    protected function printInputFileFormField($nameField, $label, $required=false, $value=null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        
    ?>
        <div class="container-upload-file">
            <?php if($value != null): ?>
                <div class="file-caricato">
                    <a target="_blank" href="<?php echo $value ?>"><img style="display: block" src="<?php echo $value ?>" /> <?php echo $this->getNomeFile($value) ?> </a>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
                <div class="<?php echo COLONNA_CONTENUTO ?>">    
                    <input name="<?php echo $nameField ?>" type="file" class="file" <?php echo $optRequired ?> />
                </div>
            </div>
        </div>
    <?php
    }
    
    private function getNomeFile($url){        
        $uploads = wp_get_upload_dir();
        $temp = explode($uploads['baseurl'].'/', $url);        
        if(count($temp) > 1){
            $temp2 = explode('/', $temp[1]);            
            if(count($temp2) > 0){
                return $temp2[2];
            }
        }
        return '';
    }
    
    protected function getInputFileFormField($nameField, $label, $required=false){
        $html = '';
        
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        
        $html.= '<div class="form-group">';
        $html.= '<label class="control-label '.COLONNA_ETICHETTA.'" for="'.$nameField.'" >'.$label.'</label>';
        $html.= '<div class="'.COLONNA_CONTENUTO.'">';
        $html.= '<input name="'.$nameField.'" type="file" class="file" '.$optRequired.' />';
        $html.= '</div>';
        $html.= '</div>';
        
        return $html;
    }
    
    /*
    protected function printImage($label, $url){
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>"> 
                <img id="<?php echo $label ?>" src="<?php echo $url ?>" alt="<?php echo $label ?>" class="img-responsive" />
            </div>
        </div>
    <?php
    }
    */
    
    
    /**
     * Funzione che stampa a video una input hidden
     * @param type $nameField
     * @param type $value
     */
    protected function printHiddenFormField($nameField, $value){
    ?>
        <input class="input-hidden" type="hidden" name="<?php echo $nameField ?>" value="<?php echo $value ?>" />
    <?php
    }
    
    
    protected function printWpEditor($value, $nameField, $settings=false){
        if($settings == true){
            $settings = array( 'media_buttons' => true );
        }
        wp_editor($value, $nameField, $settings);
    }
    
    /**
     * Funzione che stampa secondo canoni bootstrap una select box
     * @param type $nameField
     * @param type $label
     * @param type $array
     */
    protected function printSelectFormField($nameField, $label, $array, $required=false, $value=null, $disabled = null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }
        $dis = '';
        if($disabled == true){
           $dis = 'disabled';
        }
        
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">
                <select name="<?php echo $nameField ?>" id="<?php echo $nameField ?>" <?php echo $optRequired.' '.$dis ?> >
                <!-- campo vuoto -->
                <option value=""></option>
                <?php
                    foreach($array as $k => $v){
                        if($value == $k){
                            echo '<option value="'.$k.'" selected="selected" >'.$v.'</option>';
                        }
                        else{
                            echo '<option value="'.$k.'">'.$v.'</option>';
                        }                        
                    }
                ?>
                </select>
            </div>
        </div>
    <?php      
    }
    
    protected function printChosenSelectFormField($nameField, $label, $array, $required=false, $value=null, $disabled = null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        
        if($disabled == true){
            $disabled = 'disabled';
        }
        
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">
                <?php if($disabled == null): ?>
                    <select class="select chosen-<?php echo $nameField ?>"  name="<?php echo $nameField ?>" id="<?php echo $nameField ?>" <?php echo $optRequired ?> >
                    <!-- campo vuoto -->
                    <option value=""></option>
                    <?php
                        foreach($array as $k => $v){
                            if($value == $k){
                                echo '<option value="'.$k.'" selected >'.$v.'</option>';
                            }
                            else{
                                echo '<option value="'.$k.'">'.$v.'</option>';
                            }                        
                        }
                    ?>
                    </select>
                <?php else: ?>
                    <input type="text" disabled value="<?php echo $array[$value] ?>" >
                <?php endif; ?>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                  jQuery('.chosen-<?php echo $nameField ?>').chosen();
                });
            </script>
            
        </div>
    <?php      
    }
    
    /**
     * Funzione che stampa secondo canoni bootstrap una select box
     * @param type $nameField
     * @param type $label
     * @param type $array
     */
    protected function printSelectFormFieldNoKey($nameField, $label, $array, $required=false, $value=null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">
                <select name="<?php echo $nameField ?>" id="<?php echo $nameField ?>" <?php echo $optRequired ?> >
                <!-- campo vuoto -->
                <option value=""></option>
                <?php
                    foreach($array as $k => $v){
                        if($value === $k){
                            echo '<option value="'.$k.'" selected >'.$v.'</option>';
                        }
                        else{
                            echo '<option value="'.$k.'">'.$v.'</option>';
                        }                        
                    }
                ?>
                </select>
            </div>
        </div>
    <?php      
    }
    
    
    protected function printMultiSelectAdvancedFormField($nameField, $label, $array, $required=false, $value=null, $disabled = null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = $_POST[$nameField];
            }
        }     
               
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>   
            <div class="<?php echo COLONNA_CONTENUTO ?>">
                <?php if($disabled == null): ?>
                    <select name="<?php echo $nameField ?>[]" id="<?php echo $nameField ?>" class="multiselect multiselect-<?php echo $nameField ?>" multiple="multiple" <?php echo $optRequired ?>>
                        <?php
                        if($value != null){
                            foreach($array as $k => $v){
                                $trovato = false;
                                foreach($value as $item){
                                    if($item == $k){
                                        $trovato = $k;
                                    }
                                }                            
                                if($trovato != false){
                                    echo '<option value="'.$k.'" selected >'.$v.'</option>';
                                }
                                else{
                                    echo '<option value="'.$k.'">'.$v.'</option>'; 
                                }
                            }
                        }
                        else{
                            foreach($array as $k => $v){
                                if($value == $k){
                                    echo '<option value="'.$k.'" selected >'.$v.'</option>';
                                }
                                else{
                                    echo '<option value="'.$k.'">'.$v.'</option>';
                                }                        
                            }
                        }

                    ?>
                    </select>
                    <script type="text/javascript">
                        jQuery(document).ready(function() {
                          jQuery('.multiselect-<?php echo $nameField ?>').multipleSelect({
                                filter: true  
                            });
                        });
                    </script>
                <?php else: ?>
                    <?php
                        $selected = '';
                        foreach($value as $item){
                            $selected.=$array[$item].', ';
                        }
                    ?>
                    <input type="text" disabled value="<?php echo $selected ?>" >
                <?php endif; ?>
            </div>
        </div>
    <?php    
    }
    
    protected function printMultiSelectFormField($nameField, $label, $array, $required=false, $value=null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }       
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">
                <select multiple name="<?php echo $nameField ?>[]" id="<?php echo $nameField ?>" <?php echo $optRequired ?> >                             
                <?php
                    if($value != null){
                        foreach($array as $k => $v){
                            $trovato = false;
                            foreach($value as $item){
                                if($item == $k){
                                    $trovato = $k;
                                }
                            }                            
                            if($trovato != false){
                                echo '<option value="'.$k.'" selected >'.$v.'</option>';
                            }
                            else{
                                echo '<option value="'.$k.'">'.$v.'</option>'; 
                            }
                        }
                    }
                    else{
                        foreach($array as $k => $v){
                            if($value == $k){
                                echo '<option value="'.$k.'" selected >'.$v.'</option>';
                            }
                            else{
                                echo '<option value="'.$k.'">'.$v.'</option>';
                            }                        
                        }
                    }
                    
                ?>
                </select>
            </div>
        </div>
    <?php      
    }
    
    /**
     * Funzione che stampa secondo i canoni di bootstrap una input radio button
     * @param type $nameField
     * @param type $label
     * @param type $array
     * @param type $required
     * @param type $value
     */
    protected function printRadioFormField($nameField, $label, $array, $required=false, $value=null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }
        
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
        <?php
            foreach($array as $k => $v){
                if($value == $k){
                    echo '<label class="radio-inline"><input type="radio" value="'.$k.'" name="'.$nameField.'" '.$optRequired.' checked>'.$v.'</label>';
                }
                else{
                    echo '<label class="radio-inline"><input type="radio" value="'.$k.'" name="'.$nameField.'" '.$optRequired.'>'.$v.'</label>';
                }
            }
        ?>
        
        
        </div>
    <?php
    }
    
    protected function printDatePickerFormField($nameField, $label, $required=false, $value=null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
            else{
                $value = '';
            }
        }
        
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">            
                <input class="form-control datepicker-<?php echo $nameField ?>" type="text" id="<?php echo $nameField ?>" name="<?php echo $nameField ?>" value="<?php echo $value ?>" <?php echo $optRequired ?> />
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                  jQuery('.datepicker-<?php echo $nameField ?>').datepicker({
                        language: "it",
                        autoclose: true,
                        todayHighlight: true
                    });
                });
            </script>
        </div>
    <?php  
    }
    
    protected function printSearchDatePickerFormField($nameField, $label, $required=false, $value=null){
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>"> 
                <select style="float:left; margin-right: 10px" name="<?php echo $nameField ?>-operatore" id="<?php echo $nameField ?>-operatore" <?php echo $optRequired ?> >
                <!-- campo vuoto -->
                <option value=""></option>
                <?php
                    foreach($this->getOperatori() as $key => $value2){
                        if($value == $value2){
                            echo '<option value="'.$key.'" selected >'.$value2.'</option>';
                        }
                        else{
                            echo '<option value="'.$key.'">'.$value2.'</option>';
                        }                        
                    }
                ?>
                </select>
                <input style="float:left; width:80%" class="form-control datepicker-<?php echo $nameField ?>" type="text" id="<?php echo $nameField ?>" name="<?php echo $nameField ?>" value="<?php echo $value ?>" <?php echo $optRequired ?> />
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                  jQuery('.datepicker-<?php echo $nameField ?>').datepicker({
                        language: "it",
                        autoclose: true,
                        todayHighlight: true
                    });
                });
            </script>
        </div>
    <?php  
    }
    
    /**
     * Funzione che stampa un datepicker semplice sulla data di nascita
     * @param type $nameField
     * @param type $label
     * @param type $required
     * @param type $value
     */
    protected function printDateBirthdayFormField($nameField, $label, $required=false, $value=null){
        //il formato da assumere è yyyy-mm-dd
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        $date = array();
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }
        if($value != null){
            //spacco il valore
            $temp = explode('-', $value);
            if(count($temp) > 0){
                $date['d'] = intval($temp[2]);
                $date['m'] = $temp[1];
                $date['y'] = intval($temp[0]);
            }
        }
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">
                <!-- giorni -->
                <select class="<?php echo COLONNA_ETICHETTA ?>" name="<?php echo $nameField ?>-d" <?php echo $optRequired ?> >
                <?php
                    for($i=1; $i <= 31; $i++){
                        if($i == $date['d']){
                            echo '<option value="'.$i.'" selected >'.$i.'</option>';
                        }
                        else{
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                ?>
                </select>
                <!-- mesi -->
                <select class="col-sm-4" name="<?php echo $nameField ?>-m" <?php echo $optRequired ?> >
                    <?php
                        foreach($this->mesi as $k => $v){
                            if($date['m'] == $k){
                                echo '<option value="'.$k.'" selected >'.$v.'</option>';
                            }
                            else{
                                echo '<option value="'.$k.'" >'.$v.'</option>';
                            }
                        }
                    ?>
                </select>
                <!-- anni -->
                <select class="col-sm-3" name="<?php echo $nameField ?>-y" <?php echo $optRequired ?> >
                    <?php
                        for($i= ($this->annoCorrente-100); $i <= $this->annoCorrente; $i++){
                            if($date['y'] == $i){
                                echo '<option value="'.$i.'" selected>'.$i.'</option>';
                            }
                            else{
                                echo '<option value="'.$i.'">'.$i.'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
    <?php
    }
    
    /**
     * Funzione che stampa un secondo tipo di datepicker che punta sulla data odierna di default
     * @param type $nameField
     * @param type $label
     * @param type $required
     * @param type $value
     */
    protected function printDateFormField($nameField, $label, $required=false, $value=null){
        //il formato da assumere è yyyy-mm-dd
        $optRequired = "";
        if($required == true){
            $optRequired = "required";
        }
        $date = array();
        if($value == null){
            if(isset($_POST[$nameField])){
                $value = stripslashes($_POST[$nameField]);
            }
        }
        if($value != null){
            //spacco il valore
            $temp = explode('-', $value);
            if(count($temp) > 0){
                $date['d'] = intval($temp[2]);
                $date['m'] = $temp[1];
                $date['y'] = intval($temp[0]);
            }
        }
        
    ?>
        <div class="form-group">
            <label class="control-label <?php echo COLONNA_ETICHETTA ?>" for="<?php echo $nameField ?>" ><?php echo $label ?></label>
            <div class="<?php echo COLONNA_CONTENUTO ?>">
                <!-- giorni -->
                <select class="<?php echo COLONNA_ETICHETTA ?>" name="<?php echo $nameField ?>-d" <?php echo $optRequired ?> >
                <?php
                    for($i=1; $i <= 31; $i++){
                        if(count($date) > 0){
                            //Se è un valore già ottenuto
                            if($i == $date['d']){
                                echo '<option value="'.$i.'" selected >'.$i.'</option>';
                            }
                            else{
                                echo '<option value="'.$i.'">'.$i.'</option>';
                            }
                        }
                        else{
                            //altrimenti mostro il giorno corrente
                            if($i == intval($this->giornoCorrente)){
                                echo '<option value="'.$i.'" selected >'.$i.'</option>';
                            }
                            else{
                                echo '<option value="'.$i.'">'.$i.'</option>';
                            }                            
                        }
                    }
                ?>
                </select>
                <!-- mesi -->
                <select class="col-sm-4" name="<?php echo $nameField ?>-m" <?php echo $optRequired ?> >
                    <?php
                        foreach($this->mesi as $k => $v){
                            if(count($date) > 0){
                                if($date['m'] == $k){
                                    echo '<option value="'.$k.'" selected >'.$v.'</option>';
                                }
                                else{
                                    echo '<option value="'.$k.'" >'.$v.'</option>';
                                }
                            }
                            else{
                                if($k == $this->meseCorrente){
                                    echo '<option value="'.$k.'" selected >'.$v.'</option>';
                                }
                                else{
                                    echo '<option value="'.$k.'" >'.$v.'</option>';
                                }                                
                            }
                        }
                    ?>
                </select>
                <!-- anni -->
                <select class="col-sm-3" name="<?php echo $nameField ?>-y" <?php echo $optRequired ?> >
                    <?php
                        for($i= ($this->annoCorrente-1); $i <= $this->annoCorrente+1; $i++){
                            if(count($date) > 0){                            
                                if($date['y'] == $i){
                                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                }
                                else{
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                            }
                            else{
                                if($i == $this->annoCorrente){
                                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                }
                                else{
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }                                    
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
    <?php
    }
    
    
    protected function printSeachButton($nameField, $label){
    ?>
        <button type="button" class="btn <?php echo $nameField ?>"><?php echo $label ?></button>
    <?php
    }
    
    protected function printSubmitFormField($nameField, $label){
    ?>
        <input name="<?php echo $nameField ?>" type="submit" class="btn btn-success" value="<?php echo $label ?>" />
    <?php
    }
    
    
    protected function printActionDettaglio($nameField){
    ?>
        <input name="update-<?php echo $nameField ?>" type="submit" class="btn btn-primary" value="Aggiorna" />
        <input name="delete-<?php echo $nameField ?>" type="submit" class="btn btn-danger" value="Cancella" />
    <?php
    }
    
    protected function printDeleteDettaglio($nameField){
    ?>        
        <input name="<?php echo FRM_DELETE.$nameField ?>" type="submit" class="btn btn-danger" value="Elimina" />
    <?php    
    }
    
    protected function printUpdateDettaglio($nameField){
    ?>
        <input name="<?php echo FRM_UPDATE.$nameField ?>" type="submit" class="btn btn-primary" value="Aggiorna" />
    <?php    
    }
    
    protected function printButtonUrl($nameField, $url){
    ?>
        <a class="btn" href="<?php echo home_url().'/'.$url ?>"><?php echo $nameField ?></a>
    <?php    
    }
    
    static function printButtonUrl2($nameField, $url){
    ?>
        <a class="btn" href="<?php echo home_url().'/'.$url ?>"><?php echo $nameField ?></a>
    <?php    
    }
    
    
    /**
     * Stampa un box di messaggio di errore
     * @param type $message
     */
    static function printErrorBoxMessage($message){
        $html = '<div class="alert alert-danger" role="alert">';
        $html .=    '<strong>Errore! </strong> '.$message;
        $html .= '</div>';
        return $html;      
    }
    
    protected function printWarningBoxMessage($message){
        $html = '<div class="alert alert-warning" role="alert">';
        $html .= '<strong>Attenzione! </strong>'. $message;
        $html .= '</div>';        
        return $html;
    }
    
    /**
     * La funzione restituisce il box message di errore con testo settato
     * @param type $field
     * @return type
     */
    protected function printErrorMessage01($field){
        return $this->printErrorBoxMessage('Campo '.$field.' mancante o non corretto');
    }
    
    /**
     * Stampa un box di messaggio di ok
     * @param type $message
     */
    protected function printOkBoxMessage($message){
        $html = '<div class="alert alert-success" role="alert">';
        $html .= '<strong>OK! </strong> '.$message;
        $html .= '</div>';
        return $html;    
    }
    
    /**
     * La funzione stampa il messaggio dopo aver cercato di salvare l'oggetto nel database
     * @param type $type
     * @param type $save
     * @return type
     */
    protected function printMessageAfterSave($type, $save){
        // save == -1 --> elemento già inserito
        // save == false --> errore
        // save > 0 --> salvataggio con successo
                
        if($save === -1){
            return $this->printErrorBoxMessage($type.' già presente nel sistema.');            
        }
        else if($save === false){
            return $this->printErrorBoxMessage('Errore nel salvataggio!');
        }
        else if($save > 0){
            return $this->printOkBoxMessage('Salvataggio avvenuto con successo!');            
        }        
        return;        
    }
    
    /**
     * Stampa il messaggio dopo aver cercato di aggiornare l'oggetto nel database
     * @param type $update
     * @return type
     */
    protected function printMessageAfterUpdate(bool $update) : string{
        if($update === true){
            unset($_POST);  
            return $this->printOkBoxMessage('Aggiornamento avvenuto con successo!');                      
        }
        else if($update === false){
            return $this->printOkBoxMessage('Aggiornamento avvenuto con successo!');             
        }
    }
    
    /**
     * Stampa il messaggio dopo aver cercato di elminare l'oggetto dal database
     * @param type $delete
     * @return type
     */
    protected function printMessageAfterDelete($delete){
        if($delete === true){
            unset($_POST);  
            return $this->printOkBoxMessage('Eliminazione avvenuta con successo!');                      
        }
        else if($delete === false){
            return $this->printErrorBoxMessage('Errore nella cancellazione');            
        }
        
    }
    
    protected function printNoResults($type){
    ?>
        <p style="margin-top:30px">Non è stata trovata alcuna <?php echo $type ?></p>
    <?php
    }
    
    /**
     * Stampa una tabella di Bootstrap con effetto hover
     * @param type $header
     * @param type $bodyTable
     */
    protected function printTableHover($header, $bodyTable){
        //bodytable è un html del corpo della tabella
        //è diverso per ogni oggetto e viene descritto nelle classi view corrispettive
    ?>
        <table class="table table-hover">
            <thead>
                <tr>
    <?php
            foreach($header as $h){
    ?>                
                    <th><?php echo $h ?></th>
    <?php
            }
    ?>
                </tr>
            </thead>
            <tbody>
                <?php $this->printBodyTable($bodyTable) ?>
            </tbody>
        </table>
    <?php    
    }
    
    protected function printBodyTable($rows){
        foreach($rows as $colonne){
    ?>        
            <tr>
            <?php foreach($colonne as $colonna){ ?>        
                <td><?php echo $colonna ?> </td>
            <?php } ?>        
            </tr>
    <?php 
        }
    }
    
    /**
     * Restituisce un campo text in due modalità: non editabile ed editabile
     * @param type $formField
     * @param type $text
     * @param type $edit
     * @return type
     */
    protected function printTextField($formField, $text, $edit=false){
        
        $result = "";
        if($edit == true){
            //campo editabile 
           $result = '<input type="text" name="'.$formField.'" value="'.$text.'" />';
        }
        else{
            $result = $text;
        }
        
        return $result;
    }
    
    /**
     * Restituisce l'html per un piccolo form di aggiornamento di un campo
     * @param type $id
     * @param type $fieldUPDATE
     * @return string
     */
    protected function printUpdateFieldForm($id, $nameField, $fieldUPDATE){
        $html = "";
        $html.= '<form action="'.curPageURL().'" method="POST">';
        $html.= '<input type="hidden" name="id" value="'.$id.'" />';
        $html.= $fieldUPDATE;
        $html.= '<input type="submit" name="update-'.$nameField.'" class="btn btn-primary" value="AGGIORNA">';
        $html.= '</form>';
        
        return $html;
    }
    
    /**
     * Restituisce l'html per un piccolo form di cancellazione di un record dal database
     * @param type $id
     * @return string
     */
    protected function printDeleteForm($id, $nameField){
        $html = "";
        $html.= '<form action="'.curPageURL().'" method="POST">';
        $html.= '<input type="hidden" name="id" value="'.$id.'" />';        
        $html.= '<input type="submit" name="delete-'.$nameField.'" class="btn btn-danger" value="CANCELLA">';
        $html.= '</form>';
        
        return $html;
    }

    public function translateDate($date){       
        //la data si suddivide in nome del giorno, numero e mese        
        $temp = explode('-', $date);
        $giorno = $this->giorni[$temp[0]];
        $mese = $this->mesi[$temp[2]];
        
        return $giorno.' '.$temp[1].' '.$mese;
    }
    
    public function translateBirthDayDate($date){
        $temp = explode('-', $date);
        return $temp[2].' - '.$temp[1].' - '.$temp[0];
    }
    
    protected function printArraySuggestion($array){
        $array = array_unique($array);
        
        $count = 0;
        $html = "";
        foreach($array as $item){
            if($count < count($array) -1){
                $html.= '"'.$item.'",';
            }
            else{
                $html.= '"'.$item.'"';
            }
            $count++;
        }
        return $html;
    }
    
    
    public function getCountries(){
        return $this->countries;
    }
    
    protected function getProvince(){
        return $this->province;
    }
    
    /**
     * LA funzione pulisce i campi del form di ricerca
     */
    public function resetFieldsSearchBox(){
        if(isset($_POST['ricerca-reset'])){
            unset($_POST);
        }
    }
    
    protected function getOperatori(){
        return $this->operatore;
    }
    
    /**
     * La funzione restituisce il bottone dettaglio di un determinato elemento
     * @param type $url
     * @param type $id
     * @return type
     */
    protected function getDetailsButton($url, $id){   
        return '<a href="'.home_url().'/'.$url.'?ID='.$id.'" class="btn btn-info" role="button">Vedi dettagli</a>';    
    }
    
    protected function printTableResults($array){
        
    }
    

    protected function printNonAutorizzato(){
        return '<p class="error">Non sei autorizzato a vedere questa pagina</p>';
    }

}
