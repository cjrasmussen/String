<?php

namespace cjrasmussen\String;

use Exception;

class Check
{
	/**
	 * Determine if a string is JSON
	 *
	 * @param string $string
	 * @return bool
	 */
	public static function isJson(string $string): bool
	{
		if (is_numeric($string)) {
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
		if (($haystack) && ($needle)) {
			return (false !== strpos($haystack, $needle));
		}

		return $default;
	}
}
