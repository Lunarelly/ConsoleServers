<?php

declare(strict_types=1);

namespace lunarelly\consoleservers\server;

use pocketmine\utils\Config;
use Symfony\Component\Filesystem\Path;
use JsonException;

final class ServerManager
{
	/** @var AdditionalServer[] */
	private array $servers = [];
	private Config $dataConfig;

	public function __construct(string $dataFolder)
	{
		$this->dataConfig = new Config(Path::join($dataFolder, "servers.json"), Config::JSON);
		foreach ($this->dataConfig->getAll() as $name => $server) {
			$this->servers[] = AdditionalServer::fromArray($name, $server);
		}
	}

	public function getAllServers(): array
	{
		return $this->servers;
	}

	public function getServer(int $index): ?AdditionalServer
	{
		return $this->servers[$index] ?? null;
	}

	public function addServer(AdditionalServer $server): void
	{
		$this->servers[] = $server;
		$this->dataConfig->set($server->getName(), $server->toArray());
	}

	public function editServer(AdditionalServer $server, string $previousName): void
	{
		$this->dataConfig->remove($previousName);
		$this->dataConfig->set($server->getName(), $server->toArray());
	}

	public function removeServer(int $index): void
	{
		if (($server = $this->getServer($index)) !== null) {
			unset($this->servers[$index]);
			$this->dataConfig->remove($server->getName());
		}
	}

	/** @throws JsonException */
	public function close(): void
	{
		$this->dataConfig->save();
	}
}