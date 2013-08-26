<?php

class MainController {

    private $f3;

    function __construct() { }
	
	//Permet d'exécuter du code avant l'interprétation de la route par le routing engine
	function beforeroute($instanceF3) {
        $this->f3 = $instanceF3;
    }
	
	function home() {
		if(!$this->f3->exists('SESSION.is_connected'))
            echo '<a href="'.$this->f3->get('BASE').'/connecter">Se connecter</a>';
        else
            echo '<a href="'.$this->f3->get('BASE').'/deconnecter">Se déconnecter</a>';
	}

	function login() {
		if($this->f3->exists('SESSION.is_connected'))
            $this->f3->reroute('/accueil');
        else {
			$this->f3->set('SESSION.is_connected', 1);
			$this->f3->reroute('/accueil');
        }
	}

	function logout() {
		if($this->f3->exists('SESSION.is_connected'))
            $this->f3->clear('SESSION');
        $this->f3->reroute('/accueil');
	}
    
    //Permet d'exécuter du code après l'interprétation de la route par le routing engine
    function afterroute() { }

    function __destruct() { }
}

?>