<?php
namespace cjrasmussen\String;

use Exception;

class Strings
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
	 * Returns the best-guess possessive form of a word
	 *
	 * @param string $word
	 * @return string
	 */
	public static function possessive(string $word): string
	{
		if (strtolower(substr($word, -1)) === 's') {
			$word .= "'";
		} else {
			$word .= "'s";
		}

		return $word;
	}

	/**
	 * Determine if a string is JSON
	 *
	 * @param string|null $string
	 * @return bool
	 */
	public static function isJson(?string $string): bool
	{
		if (($string === null) || (is_numeric($string))) {
			return false;
		}

		try {
			json_decode($string, false, 512, JSON_THROW_ON_ERROR);
		} catch (Exception $e) {
			return false;
		}

		return true;
	}

	/**
	 * Determine if a string contains HTML
	 *
	 * @param string $string
	 * @return bool
	 */
	public static function isHtml(string $string): bool
	{
		return ($string !== strip_tags($string));
	}

	/**
	 * Determine if a string is HTML encoded
	 *
	 * @param string $string
	 * @return bool
	 */
	public static function isHtmlEncoded(string $string): bool
	{
		return preg_match('|&([#a-zA-Z0-9]+);|i', $string);
	}

	/**
	 * Determine if a string is a palindrome
	 *
	 * Ignores case and punctuation unless optional $strict parameter is set to true
	 *
	 * @param string $string
	 * @param bool $strict
	 * @return bool
	 */
	public static function isPalindrome(string $string, bool $strict = false): bool
	{
		if (!$strict) {
			$string = strtolower(preg_replace("/[^[[:alnum:]]+/U", '', $string));
		}

		return (strrev($string) === $string);
	}

	/**
	 * Determine if two strings are anagrams of each other
	 *
	 * Ignores case and punctuation unless optional $strict parameter is set to true
	 *
	 * @param string $string1
	 * @param string $string2
	 * @param bool $strict
	 * @return bool
	 */
	public static function isAnagram(string $string1, string $string2, bool $strict = false): bool
	{
		if (!$strict) {
			$string1 = strtolower(preg_replace("/[^[[:alnum:]]+/U", '', $string1));
			$string2 = strtolower(preg_replace("/[^[[:alnum:]]+/U", '', $string2));
		}

		if (strlen($string1) !== strlen($string2)) {
			return false;
		}

		return (count_chars($string1) === count_chars($string2));
	}

	/**
	 * Determine if a string haystack contains string needle, with a default response for if needle is null
	 *
	 * @param string $haystack
	 * @param string|null $needle
	 * @param bool $default
	 * @return bool
	 */
	public static function strContains(string $haystack, ?string $needle = null, bool $default = true): bool
	{
		if (($haystack) AND ($needle)) {
			return (false !== strpos($haystack, $needle));
		}

		return $default;
	}

	/**
	 * Return a dash if the supplied value is null
	 *
	 * @param string|int|null $input
	 * @param string $dash
	 * @return string
	 */
	public static function nullToDash($input, string $dash = '&mdash;'): string
	{
		return $input ?? $dash;
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

		preg_match_all('/\B(#\w+\b)/', $text, $matches);

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
}
