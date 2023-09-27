<?php

    $connexion = null;
    try {
		$connexion = new PDO('mysql:host=localhost;dbname=unishare', 'root', '');
	}catch(Exception $e){
		die("Erreur co bdd" . $e->getMessage());
	}
?>