<?php

declare(strict_types=1);

namespace lunarelly\consoleservers\query;

readonly class QueryResult
{
	public function __construct(
		private string $name,
		private string $version,
		private int $players,
		private int $maxPlayers
	) {}

	public function getName(): string
	{
		return $this->name;
	}

	public function getVersion(): string
	{
		return $this->version;
	}

	public function getPlayers(): int
	{
		return $this->players;
	}

	public function getMaxPlayers(): int
	{
		return $this->maxPlayers;
	}
}