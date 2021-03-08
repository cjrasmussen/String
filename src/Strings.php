<?php
namespace cjrasmussen\String;

class Strings
{
	public const FILTER_ALPHA = 1;
	public const FILTER_NUM = 2;
	public const FILTER_ALPHANUM = 3;

	/**
	 * Returns
	 *
	 * @param string $string
	 * @param int $return_type
	 * @return string
	 */
	public static function filterChars($string, $return_type = self::FILTER_ALPHANUM): string
	{
		switch ($return_type) {
			case self::FILTER_ALPHA:
				return preg_replace('|[^A-Za-z]|', '', $string);
			case self::FILTER_NUM:
				return preg_replace('|[^0-9]|', '', $string);
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
	public static function possessive($word): string
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
	 * @param string $string
	 * @return bool
	 */
	public static function isJson($string): bool
	{
		if (is_numeric($string)) {
			return false;
		}

		json_decode($string, false);
		return (json_last_error() === JSON_ERROR_NONE);
	}

	/**
	 * Determine if a string contains HTML
	 *
	 * @param string $string
	 * @return bool
	 */
	public static function isHtml($string): bool
	{
		return ($string !== strip_tags($string));
	}

	/**
	 * Determine if a string is HTML encoded
	 *
	 * @param string $string
	 * @return bool
	 */
	public static function isHtmlEncoded($string): bool
	{
		return preg_match('|&([#a-zA-Z0-9]+);|i', $string);
	}

	/**
	 * Determine if a string haystack contains string needle, with a default response for if needle is null
	 *
	 * @param string $haystack
	 * @param string|null $needle
	 * @param bool $default
	 * @return bool
	 */
	public static function strContains($haystack, $needle = null, $default = true): bool
	{
		if (($haystack) AND ($needle)) {
			return (false !== strpos($haystack, $needle));
		}

		return $default;
	}
}
