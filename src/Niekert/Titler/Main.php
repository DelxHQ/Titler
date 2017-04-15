<?php

namespace Niekert\Titler;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\network\protocol\SetTitlePacket;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\event\entity\EntityLevelChangeEvent;

class Main extends PluginBase implements Listener{

	public function onLoad(){
		$this->getLogger()->info("Plugin Loading");
	}
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->saveDefaultConfig();
		$this->reloadConfig();
		$this->JoinTitle = $this->getConfig()->get("JoinTitle");
		$this->JoinSubtitle = $this->getConfig()->get("JoinSubtitle");
		$this->WorldTitle = $this->getConfig()->get("WorldTitle");
		$this->WorldSubtitle = $this->getConfig()->get("WorldSubtitle");
		$this->Fadein = $this->getConfig()->get("Fadein")*20;
		$this->Duration = $this->getConfig()->get("Duration")*20;
		$this->Fadeout = $this->getConfig()->get("Fadeout")*20;
		
			if($this->JoinTitle === "" OR $this->JoinSubtitle === "" OR $this->WorldTitle === "" OR $this->WorldSubtitle === "" OR $this->Fadein === "" OR $this->Duration === "" OR $this->Fadeout === ""){
					$this->getLogger()->warning('Please edit your config.yml');
					$this->setEnabled(false);
			}
		
		$this->getLogger()->info("Plugin Enabled");
	}
	
	public function onDisable(){
		$this->getLogger()->info("Plugin Disabled");
	}
	
	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$player->addTitle(str_replace(array('{player}', '{world}'), array($player->getName(), $player->getLevel()->getName()), $this->JoinTitle), str_replace(array('{player}', '{world}'), array($player->getName(), $player->getLevel()->getName()), $this->JoinSubtitle), $fadeIn = $this->Fadein, $duration = $this->Duration, $fadeOut = $this->Fadeout); 
		$player->addTitle("Hallo"); 
	}
	
	public function onWorldChange(EntityLevelChangeEvent $event){
		$player = $event->getEntity();
		$player->sendTitle("str_replace(array('{player}', '{world}'), array('$player->getName()', '$player->getLevel()->getName()'), $this->WorldTitle)", "str_replace(array('{player}', '{world}'), array($player, $player->getLevel()->getName()), $this->WorldSubtitle)", $fadeIn = $this->Fadein, $duration = $this->Duration, $fadeOut = $this->Fadeout); 
	}
}