<?php

declare(strict_types=1);

namespace Benda95280\MyEntities\commands;

use Benda95280\MyEntities\commands\arguments\MYEItemArgument;
use Benda95280\MyEntities\commands\arguments\PlayerNameTargetArgument;
use Benda95280\MyEntities\MyEntities;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use pocketmine\command\CommandSender;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class ItemCommand extends BaseSubCommand
{
    /**
     * This is where all the arguments, permissions, sub-commands, etc would be registered
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->setPermission("MyEntities.give");
        $this->registerArgument(0, new MYEItemArgument("item", false));
        $this->registerArgument(1, new PlayerNameTargetArgument("player", true));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $player = $args["player"] ?? $sender;
        if (!$player instanceof Player) return;

        if (!empty($itemName = ($args["item"] ?? ""))) {
            if ($itemName === "rotator") {
                $item = ItemFactory::get(ItemIds::STICK /* ID */, 0 /* Item Damage/meta */, 1 /*Count*/);
                $item->setCustomName("§6**Obj Rotation**");
                $player->getInventory()->addItem($item);
                $player->sendMessage(TextFormat::colorize(sprintf(MyEntities::getInstance()->getConfig()->get("messages")['message-head-added'], "Obj_Rotation")));

            } else if ($itemName === "remover") {
                $item = ItemFactory::get(ItemIds::STICK /* ID */, 0 /* Item Damage/meta */, 1 /*Count*/);
                $item->setCustomName("§6**Obj Remover**");
                $player->getInventory()->addItem($item);
                $player->sendMessage(TextFormat::colorize(sprintf(MyEntities::getInstance()->getConfig()->get("messages")['message-head-added'], "Obj_Remover")));
            } else $sender->sendMessage(MyEntities::PREFIX . "Error: Item do not exist !");
        } else $sender->sendMessage(MyEntities::PREFIX . "Error: Item error !");
    }
}
