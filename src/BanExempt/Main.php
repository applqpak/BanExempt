<?php

  namespace BanExempt;

  use pocketmine\plugin\PluginBase;
  use pocketmine\event\Listener;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\utils\Config;
  use pocketmine\Player;
  use pocketmine\event\player\PlayerPreLoginEvent;
  use pocketmine\event\player\PlayerCommandPreprocessEvent;

  class Main extends PluginBase implements Listener {

    public function dataPath() {

      return $this->getDataFolder();

    }

    public function onEnable() {

      @mkdir($this->dataPath());

      $this->cfg = new Config($this->dataPath() . "config.yml", Config::YAML, array("exempt_ban_permission" => "ban.exempt", "exempt_kick_permission" => "kick.exempt"));

    }

    public function onCommandPreprocess(PlayerCommandPreprocessEvent $event) {

      $command = explode(" ", strtolower($event->getMessage()));

      $sender = $event->getPlayer();

      if$command[0] === "/kick" and $command[1] !== null) {

        $player = $this->getServer()->getPlayer($command[1]);

        $event->setCancelled();

        if($player === null) {

          $sender->sendMessage(TF::RED . "Player " . $player . " is not online.");

        } else {

          if($player->hasPermission($this->cfg->get("exempt_kick_permission")));

            $sender->sendMessage(TF::RED . "Player " . $player . " is not allowed to be kicked.");

          }

        }

      }

    }

    public function onPreLogin(PlayerPreLoginEvent $event) {

      $player = $event->getPlayer();

      if($player->isBanned()) {

        if($player->hasPermission($this->cfg->get("exempt_ban_permission"))) {

          $player->setBanned(false);

        }

      }

    }

  }

?>
