<?php

namespace Niekert\Titler;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\player\PlayerJoinEvent;
use Niekert\Titler\SendTitle;

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
		$this->getLogger()->info("Plugin Enabled");

			if($this->JoinTitle === "" OR $this->JoinSubtitle === "" OR $this->WorldTitle === "" OR $this->WorldSubtitle === ""){
					$this->getLogger()->warning('Please edit your config.yml');
					$this->setEnabled(false);
			}
	}
	
	public function onDisable(){
		$this->getLogger()->info("Plugin Disabled");
	}
	
	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$task = new SendTitle($this, $event->getPlayer(), str_replace(array('{player}', '{world}'), array($event->getPlayer()->getName(), $event->getPlayer()->getLevel()->getName()), $this->JoinTitle), str_replace(array('{player}', '{world}'), array($event->getPlayer()->getName(), $event->getPlayer()->getLevel()->getName()), $this->JoinSubtitle), $this->Fadein, $this->Duration, $this->Fadeout);
		$this->getServer()->getScheduler()->scheduleDelayedTask($task, 20);
	}
	
	public function onWorldChange(EntityLevelChangeEvent $event){
		$player = $event->getEntity();
		$task = new SendTitle($this, $event->getEntity(), str_replace(array('{player}', '{world}'), array($event->getEntity()->getName(), $event->getEntity()->getLevel()->getName()), $this->WorldTitle), str_replace(array('{player}', '{world}'), array($event->getEntity()->getName(), $event->getEntity()->getLevel()->getName()), $this->WorldSubtitle), $this->Fadein, $this->Duration, $this->Fadeout);
		$this->getServer()->getScheduler()->scheduleDelayedTask($task, 20);
	}
}