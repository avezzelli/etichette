<?php

namespace etichette;

/********************* CLASSI MODEL *********************/
require_once 'model/Template.php';
require_once 'model/Voce.php';
require_once 'model/Categoria.php';
require_once 'model/Cliente.php';
require_once 'model/Etichetta.php';
require_once 'model/Traduzione.php';
require_once 'model/VoceTradotta.php';


/********************* CLASSI DAO *********************/
require_once 'dao/VoceDAO.php';
require_once 'dao/CategoriaDAO.php';
require_once 'dao/TemplateDAO.php';
require_once 'dao/ClienteDAO.php';
require_once 'dao/EtichettaDAO.php';
require_once 'dao/TraduzioneDAO.php';
require_once 'dao/VoceTradottaDAO.php';


/********************* CLASSI CONTROLLER *********************/
require_once 'controller/EtichettaController.php';
require_once 'controller/ClienteController.php';
require_once 'controller/TraduzioneController.php';


/********************* CLASSI VIEW *********************/
require_once 'view/ClienteView.php';
require_once 'view/EtichettaView.php';
require_once 'view/TraduzioneView.php';