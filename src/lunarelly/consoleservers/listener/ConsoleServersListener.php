<?php

declare(strict_types=1);

namespace lunarelly\consoleservers\listener;

use lunarelly\consoleservers\form\FormManager;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

final readonly class ConsoleServersListener implements Listener
{
	public function __construct(private FormManager $formManager)
	{
	}

	public function handlePlayerJoin(PlayerJoinEvent $event): void
	{
		$this->formManager->sendServerListForm($event->getPlayer());
	}
}