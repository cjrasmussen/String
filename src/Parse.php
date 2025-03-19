<?php
namespace cjrasmussen\String;

use Exception;

class Parse
{
	public const FILTER_ALPHA = 1;
	public const FILTER_NUM = 2;
	public const FILTER_ALPHANUM = 3;

	/**
	 * Returns a string with the specified character set filtered out
	 *
	 * @param string|null $string
	 * @param int $return_type
	 * @return string
	 */
	public static function filterChars(?string $string, int $return_type = self::FILTER_ALPHANUM): string
	{
		if (!$string) {
			return '';
		}

		switch ($return_type) {
			case self::FILTER_ALPHA:
				return preg_replace('|[^A-Za-z]|', '', $string);
			case self::FILTER_NUM:
				return preg_replace('|\D|', '', $string);
			default:
				return preg_replace('|[^A-Za-z0-9]|', '', $string);
		}
	}

	/**
	 * Return an array of URLs appearing in a string
	 *
	 * Array of objects including the URL, start position, and end position
	 *
	 * @param string $text
	 * @return array
	 */
	public static function getUrls(string $text): array
	{
		$output = [];

		preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w]+\)|([^[:punct:]\s]|/))#', $text, $matches);

		if (count($matches[0])) {
			$offset = 0;
			foreach ($matches[0] AS $url) {
				$start = strpos($text, $url, $offset);
				$offset = $end = $start + strlen($url);
				$output[] = (object)[
					'url' => $url,
					'start' => $start,
					'end' => $end,
				];
			}
		}

		return $output;
	}

	/**
	 * Return an array of "hashtags" appearing in a string
	 *
	 * Array of objects including the hashtag, the text without the hash sign, start position, and end position
	 *
	 * @param string $text
	 * @return array
	 */
	public static function getHashtags(string $text): array
	{
		$output = [];

		preg_match_all('/#(\\w+)/', $text, $matches);

		if (count($matches[0])) {
			$offset = 0;
			foreach ($matches[0] AS $hashtag) {
				$start = strpos($text, $hashtag, $offset);
				$offset = $end = $start + strlen($hashtag);
				$output[] = (object)[
					'hashtag' => $hashtag,
					'text' => substr($hashtag, 1),
					'start' => $start,
					'end' => $end,
				];
			}
		}

		return $output;
	}

	/**
	 * Lazy method of determining the proper indefinite article for a word
	 *
	 * @param string $word
	 * @return string
	 */
	public static function getLazyIndefiniteArticle(string $word): string
	{
		$vowels = ['a', 'e', 'i', 'o', 'u'];
		return (in_array($word[0], $vowels, true)) ? 'an' : 'a';
	}
}
