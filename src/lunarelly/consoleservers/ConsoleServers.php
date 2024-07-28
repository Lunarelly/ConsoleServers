<?php

declare(strict_types=1);

namespace lunarelly\consoleservers;

use lunarelly\consoleservers\form\FormManager;
use lunarelly\consoleservers\listener\ConsoleServersListener;
use lunarelly\consoleservers\locale\Translator;
use lunarelly\consoleservers\server\ServerManager;
use pocketmine\plugin\PluginBase;
use JsonException;

final class ConsoleServers extends PluginBase
{
	private ServerManager $serverManager;

	protected function onEnable(): void
	{
		Translator::initialize($this);
		$this->serverManager = new ServerManager($this->getDataFolder());
		$this->getServer()->getPluginManager()->registerEvents(new ConsoleServersListener(new FormManager($this->serverManager)), $this);
	}

	/** @throws JsonException */
	protected function onDisable(): void
	{
		$this->serverManager->close();
	}
}