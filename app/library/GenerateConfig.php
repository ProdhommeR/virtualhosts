<?php
class GenerateConfig  {
	//Programme de génération de fichier de conf
	//3 étapes (=3 fonctions) :
	// 1°) Aller chercher la valeur de conf template dans Stype en passant par le server à partir de Virtualhost
	// 2°) Aller chercher la value de VirtualHostproperties
	// 3°) Aller récupérer la template de StypeProperties ( soit par Stype ou soit par StypeProperties)
	public function GetConfTemplate(){     //Etape n°1 : recherche de la conf template de Stype
		$virtualHost= Virtualhost::findFirst();
		$server=$virtualHost->getServer();
		$stype=$server->getStype();
		$config=$stype->getConfigTemplate();
		return $config;
	}
	
	
	public function GetVhProperties(){ // Etape n°2 : Recherche de la valeur(value) contenu dans VirtualHostProperties
		$virtualHost = Virtualhost::findFirst();
		$virtualHost->getVirtualhostproperties();
		return $virtualHost;
		
	}
	
	public function GetStypeProperties(){
		$virtualHost = Virtualhost::findFirst();
		$server = $virtualHost->getServer();
		$Stype= $server->getStype();
		$properties = $Stype->getStypeproperties();
		return $properties;
	}
}