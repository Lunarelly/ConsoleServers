<?php

declare(strict_types=1);

namespace lunarelly\consoleservers\server;

use pocketmine\player\Player;

class AdditionalServer
{
	public function __construct(
		private string $name,
		private string $ip,
		private int $port
	) {}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

	public function getIp(): string
	{
		return $this->ip;
	}

	public function setIp(string $ip): void
	{
		$this->ip = $ip;
	}

	public function getPort(): int
	{
		return $this->port;
	}

	public function setPort(int $port): void
	{
		$this->port = $port;
	}

	public function transfer(Player $player): void
	{
		$player->transfer($this->ip, $this->port, $this->name);
	}

	public function toArray(): array
	{
		return [
			"ip" => $this->ip,
			"port" => $this->port
		];
	}

	public static function fromArray(string $name, array $data): self
	{
		return new self($name, $data["ip"], $data["port"]);
	}
}