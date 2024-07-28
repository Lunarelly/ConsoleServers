<?php

declare(strict_types=1);

namespace lunarelly\consoleservers\query;

use pocketmine\Server;
use Closure;
use Exception;

final class QueryManager
{
	private const MAGIC = "\x00\xff\xff\x00\xfe\xfe\xfe\xfe\xfd\xfd\xfd\xfd\x12\x34\x56\x78";
	private const PING_HEADER = "\x01";
	private const PONG_HEADER = "\x1c";

	public static function asyncQuery(string $ip, int $port, Closure $onCompletion): void
	{
		Server::getInstance()->getAsyncPool()->submitTask(new QueryAsyncTask($ip, $port, $onCompletion));
	}

	/** @internal */
	public static function getQueryData(string $ip, int $port): ?QueryResult
	{
		try {
			$socket = @fsockopen("udp://" . $ip, $port, $errorCode, $errorMessage, 1);
			if (!($socket)) {
				return null;
			}

			stream_set_timeout($socket, 1);

			fwrite($socket, self::PING_HEADER . pack("J", (int)(microtime(true) * 1000)) . self::MAGIC);
			$response = fread($socket, 2048);
			fclose($socket);

			if (empty($response) || !(str_starts_with($response, self::PONG_HEADER))) {
				return null;
			}

			$parts = explode(";", substr($response, 35));
			return new QueryResult($parts[1], $parts[3], (int)$parts[4], (int)$parts[5]);
		} catch (Exception) {
			return null;
		}
	}
}