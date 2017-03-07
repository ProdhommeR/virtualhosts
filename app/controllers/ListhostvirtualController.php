<?php
use Phalcon\Mvc\View;
use Ajax\semantic\html\modules\checkbox\HtmlCheckbox;
use Ajax\semantic\html\elements\HtmlInput;
use Ajax\semantic\html\collections\HtmlMessage;
class ListhostvirtualController extends ControllerBase {
	
	public function listhvAction($user=NULL){
		$this->loadMenus();
		$hosts=Host::find();
		
		//$item->addPopup("Propriétés","test popup");
		$list=$this->semantic->htmlList("lst-hosts");
		foreach ($hosts as $host){
			$item=$list->addItem(["icon"=>"cloud","header"=>$host->getName(),"description"=>$host->getIpv4()]);
			//$item->addPopup("Propriétés","test popup");
			$item->addToProperty("data-ajax", $host->getId());
		}
		$list->setHorizontal();
		
		$virtualhosts=Virtualhost::find();
		//$vhp=Virtualhostproperty::findFirst();
		$list=$this->semantic->htmlList("lst-virtualhosts");
		
		foreach ($virtualhosts as $virtualhost){
			$item=$list->addItem(["icon"=>"cloud","header"=>$virtualhost->getName(),"description"=>$virtualhost->getServer()->getName()]);
			$props=$virtualhost->getVirtualhostproperties();
			if(isset($props[0]))
				$item->addPopup("Propriétés :","ServeurName: ".$props[0]->getValue());
			$item->addToProperty("data-ajax", $virtualhost->getId());
			$item->getOnClick("Listhostvirtual/AfficherVh","#modification",["attr"=>"data-ajax"]);
			
			
		}
		$list->setHorizontal();
		$this->jquery->compile($this->view);
	}
	public function AfficherVhAction($idVh){
		$semantic=$this->semantic;

		$virtualhost=Virtualhost::findFirst($idVh);
		$vhp=$virtualhost->getVirtualhostproperties();
		
		$dt=$semantic->dataTable("dt","Virtualhostproperty",$vhp);
		$dt->setFields(["virtualHost","property","property","value"]);
		$dt->setCaptions(["VirtualHost","Nom","Description","Value"]);
		$dt->setValueFunction(1, function($p,$vhp){return $vhp->getProperty()->getName();});
		$dt->setValueFunction(2, function($p,$vhp){return $vhp->getProperty()->getDescription();});
		$dt->setEmptymessage(new HtmlMessage("","Rien à afficher"));
		$this->jquery->compile($this->view);
	}
}
