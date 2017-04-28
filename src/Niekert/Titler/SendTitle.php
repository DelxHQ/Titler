<?php
	
namespace Niekert\Titler;

use pocketmine\scheduler\PluginTask;
use pocketmine\Player;
use Niekert\Titler\Main;
             
class SendTitle extends PluginTask {
	public function __construct(Main $main, $player, string $title, string $subtitle, int $fadein, int $fadeout, int $duration) {
		parent::__construct($main);
		$this->player = $player;
		$this->title = $title;
		$this->subtitle = $subtitle;
		$this->fadein = $fadein;
		$this->fadeout = $fadeout;
		$this->duration = $duration;
		}
		
	public function onRun($tick){
		$player = $this->player;
		if(function_exists("sendTitle")){
			$player->sendTitle($this->title, $this->subtitle, $this->fadein, $this->duration, $this->fadeout);
			return;
		}
		elseif(function_exists("addTitle")){
			$player->addTitle($this->title, $this->subtitle, $this->fadein, $this->duration, $this->fadeout);
		}
	}
}