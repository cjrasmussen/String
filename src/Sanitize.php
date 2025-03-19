<?php

namespace cjrasmussen\String;

use InvalidArgumentException;

class Sanitize
{
	/**
	 * Sanitize a string for use as a SQL identifier
	 *
	 * This is *not* a SQL query sanitizer. It is intended to be used when building a parameterized query through string
	 * concatenation to ensure that characters that could facilitate SQL injection are not used as schema/table/field
	 * names. Such a built query would still be expected to fail.
	 *
	 * @param string $text
	 * @return string
	 */
	public static function sqlIdentifier(string $text): string
	{
		$text = stripslashes($text);
		$text = preg_replace('|;([ ]*)--|', '', $text);
		return addslashes($text);
	}

	/**
	 * Take a string list of hashtags and make sure they're all formatted properly
	 *
	 * @param string $text
	 * @param string $separator
	 * @return string
	 */
	public static function hashtagList(string $text, string $separator = ' '): string
	{
		$valid_separators = [' ', ',', ';', '.'];

		if (!in_array($separator, $valid_separators, true)) {
			$msg = 'Separator `' . $separator . '` is not valid';
			throw new InvalidArgumentException($msg);
		}

		$text = str_replace($valid_separators, $separator, $text);
		$tags = explode($separator, trim($text));
		$output = [];

		foreach ($tags AS $tag) {
			$tag = preg_replace('/[^[[:alnum:]]/i', '', $tag);
			if ($tag !== '') {
				$output[] = '#' . $tag;
			}
		}

		return implode($separator, $output);
	}
}