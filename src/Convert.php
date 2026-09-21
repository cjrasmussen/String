<?php

namespace cjrasmussen\String;

class Convert
{
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
	 * Return a dash if the supplied value is null
	 *
	 * @param int|string|float|null $input
	 * @param string $dash
	 * @return string
	 */
	public static function nullToDash(int|string|float|null $input, string $dash = '&mdash;'): string
	{
		return $input ?? $dash;
	}

	/**
	 * Turns boolean (or boolean-ish) response into yes/no
	 *
	 * @param bool|int|string|null $var
	 * @return string
	 */
	public static function booleanToYesNo(bool|int|string|null $var): string
	{
		if (($var === null) || ($var === false) || ($var === 0) || ($var === '0')) {
			return 'No';
		}

		return 'Yes';
	}
}