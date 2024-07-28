<?php

declare(strict_types=1);

namespace lunarelly\consoleservers\form;

use lunarelly\consoleservers\server\ServerManager;
use pocketmine\player\Player;

final readonly class FormManager
{
	public function __construct(private ServerManager $serverManager)
	{
	}

	public function sendServerListForm(Player $player): void
	{
	}
}