<?php

declare(strict_types=1);

namespace lunarelly\consoleservers\query;

use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\Utils;
use Closure;

final class QueryAsyncTask extends AsyncTask
{
	private const TLS_KEY_COMPLETION = "completion";

	public function __construct(
		private readonly string $ip,
		private readonly int $port,
		Closure $onCompletion
	) {
		Utils::validateCallableSignature(function (QueryResult $result): void {}, $onCompletion);
		$this->storeLocal(self::TLS_KEY_COMPLETION, $onCompletion);
	}

	public function onRun(): void
	{
		$this->setResult(QueryManager::getQueryData($this->ip, $this->port));
	}

	public function onCompletion(): void
	{
		($this->fetchLocal(self::TLS_KEY_COMPLETION))($this->getResult());
	}
}