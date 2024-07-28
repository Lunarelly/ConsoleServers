<?php

declare(strict_types=1);

namespace lunarelly\consoleservers\locale;

use lunarelly\consoleservers\ConsoleServers;
use pocketmine\player\Player;
use Symfony\Component\Filesystem\Path;

final class Translator
{
	public const DEFAULT_LOCALE = self::ENGLISH;
	public const ENGLISH = "en_US";
	public const RUSSIAN = "ru_RU";

	public const LOCALES = [
		self::ENGLISH,
		self::RUSSIAN,
	];

	/** @var string[][] */
	private static array $translations = [];

	public static function initialize(ConsoleServers $plugin): void
	{
		foreach (self::LOCALES as $locale) {
			$plugin->saveResource($path = Path::join("locale", $locale . ".ini"), true);
			self::$translations[$locale] = array_map(
				stripcslashes(...),
				parse_ini_file(Path::join($plugin->getDataFolder(), $path), false, INI_SCANNER_RAW)
			);
		}
	}

	public static function translate(string $key, Player|string $locale = self::DEFAULT_LOCALE, array $args = []): string
	{
		if ($locale instanceof Player) {
			$locale = $locale->getLocale();
		} elseif (!(is_string($locale))) {
			$locale = self::DEFAULT_LOCALE;
		}

		if (!(isset(self::$translations[$locale]))) {
			$locale = self::DEFAULT_LOCALE;
		}

		$translation = !(isset(self::$translations[$locale][$key])) ? self::$translations[self::DEFAULT_LOCALE][$key] ?? $key : self::$translations[$locale][$key];
		return empty($args) ? $translation : sprintf($translation, ...$args);
	}
}