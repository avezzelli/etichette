<?phpnamespace etichette;/************************ DEFINIZIONI **************************/define('DB_PREFIX', 'wp_etichette_');/************************ URL **************************/define('URL_ETICHETTA', home_url('/').'etichetta?url='); //link per la singola etichettadefine('URL_DETTAGLIO_CLIENTE', home_url('/').'wp-admin/admin.php?page=dettaglio-cliente&ID=');define('URL_DETTAGLIO_CATEGORIA', home_url('/').'wp-admin/admin.php?page=dettaglio-categoria&ID=');define('URL_DETTAGLIO_TEMPLATE', home_url('/').'wp-admin/admin.php?page=dettaglio-template&ID=');define('URL_DETTAGLIO_ETICHETTA', home_url('/').'wp-admin/admin.php?page=dettaglio-etichetta&ID=');/************************ TABELLE DATABASE **************************///nomi comunidefine('DBT_NOME', 'nome');//IDdefine('DBT_ID_TEM', 'id_template');define('DBT_ID_CLI', 'id_cliente');define('DBT_ID_WP', 'id_wp');define('DBT_ID_CAT', 'id_categoria');define('DBT_ID_ETI', 'id_etichetta');define('DBT_ID_VOC', 'id_voce');//Vocedefine('DBT_VOC', 'voci');define('DBT_VOC_LBL', 'label');define('DBT_VOC_VALORE', 'valore');define('DBT_VOC_TIPO', 'tipo');define('DBT_VOC_VIS', 'visualizza');//Templatedefine('DBT_TEM', 'templates');define('DBT_TEM_TIPO', 'tipo');//Categoriadefine('DBT_CAT', 'categorie');//Etichettadefine('DBT_ETI', 'etichette');define('DBT_ETI_DATA', 'data');define('DBT_ETI_URL', 'url');define('DBT_ETI_LINK', 'link');define('DBT_ETI_IMG', 'immagine');//Clientedefine('DBT_CLI', 'clienti');//Traduzionedefine('DBT_TRA', 'traduzioni');define('DBT_TRA_LINGUA', 'lingua');//Voce tradottadefine('DBT_VTR', 'voci_tradotte');define('DBT_VTR_LANG', 'lang');define('DBT_VTR_LBL', 'label');define('DBT_VTR_VAL', 'valore');define('DBT_VTR_TIP', 'tipo');define('DBT_VTR_VIS', 'visualizza');/************************ OGGETTI **************************/define('OBJ_VOC', 'voce');define('OBJ_TEM', 'template');define('OBJ_ETI', 'etichetta');define('OBJ_CAT', 'categoria');define('OBJ_CLI', 'cliente');define('OBJ_TRA', 'traduzione');define('OBJ_VTR', 'vocetradotta');/********************************* FORM *********************************///Utente Wordpressdefine('FRM_IDWP', 'idwp');//Clientedefine('FRM_CLI', 'cliente');//Categoriadefine('FRM_CAT', 'categoria');//Vocedefine('FRM_VOC', 'voce');define('FRM_VOC_LBL', FRM_VOC.'-label');define('FRM_VOC_VAL', FRM_VOC.'-valore');define('FRM_VOC_TIP', FRM_VOC.'-tipo');define('FRM_VOC_VIS', FRM_VOC.'-visualizza');//Templatedefine('FRM_TEM', 'template');define('FRM_TEM_IDETI', FRM_TEM.'-idetichetta');//Etichettadefine('FRM_ETI', 'etichetta');define('FRM_ETI_DATA', FRM_ETI.'-data');define('FRM_ETI_CATEGORIA', FRM_ETI.'-idcategoria');define('FRM_ETI_CLIENTE', FRM_ETI.'-idcliente');define('FRM_ETI_LINK', FRM_ETI.'-link');define('FRM_ETI_URL', FRM_ETI.'-url');define('FRM_ETI_TEMPLATE', FRM_ETI.'-template');define('FRM_ETI_IMMAGINE', FRM_ETI.'immagine');//Traduzionedefine('FRM_TRA', 'traduzione');define('FRM_TRA_LINGUA', 'lingua');//Voce Tradottadefine('FRM_VTR', 'vt');define('FRM_VTR_LBL', FRM_VTR.'-label');define('FRM_VTR_VAL', FRM_VTR.'-valore');define('FRM_VTR_TIP', FRM_VTR.'-tipo');define('FRM_VTR_VIS', FRM_VTR.'-visualizza');/********************************* LABEL *********************************///nomi comuni//Labeldefine('LBL_LABEL', 'Label');define('LBL_VALORE', 'Valore');define('LBL_TIPO', 'Tipo');define('LBL_CLIENTE', 'Cliente');define('LBL_TEMPLATE', 'Template');define('LBL_DATA', 'Data');define('LBL_URL', 'Url');define('LBL_LINK', 'Link');define('LBL_CATEGORIA', 'Categoria');define('LBL_VISUALIZZA', 'Opzioni di visualizzazione');define('LBL_IMMAGINE', 'Immagine');define('LBL_LINGUA', 'Lingua');define('VISUALIZZA', 1);define('NASCONDI', 0);