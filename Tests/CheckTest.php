<?php

namespace cjrasmussen\Tests;

use cjrasmussen\String\Check;
use PHPUnit\Framework\TestCase;

class CheckTest extends TestCase
{
	public function testIsJson(): void
	{
		$string = '{}';
		$this->assertTrue(Check::isJson($string));

		$string = '{"name":"John"}';
		$this->assertTrue(Check::isJson($string));

		$string = 'Random string';
		$this->assertFalse(Check::isJson($string));

		$string = 2013;
		$this->assertFalse(Check::isJson($string));
	}

	public function testIsHtml(): void
	{
		$string = 'Some random text with a <strong>bold</strong> word.';
		$this->assertTrue(Check::isHtml($string));

		$string = '<p>A paragraph of text with a <strong>bold</strong> word.</p>';
		$this->assertTrue(Check::isHtml($string));

		$string = 'Malformatted text that <em>contains a tag but not a closing tag';
		$this->assertTrue(Check::isHtml($string));

		$string = 'Boring old plaintext';
		$this->assertFalse(Check::isHtml($string));
	}

	public function testIsHtmlEncoded(): void
	{
		$string = 'This string is not HTML encoded';
		$this->assertFalse(Check::isHtmlEncoded($string));

		$string = 'This string has &quot;some&quot; HTML encoding';
		$this->assertTrue(Check::isHtmlEncoded($string));
	}

	public function testIsPalendrome(): void
	{
		$string = 'tacocat';
		$this->assertTrue(Check::isPalindrome($string));
		$this->assertTrue(Check::isPalindrome($string, true));

		$string = 'taco cat';
		$this->assertTrue(Check::isPalindrome($string));
		$this->assertFalse(Check::isPalindrome($string, true));

		$string = 'palendrome';
		$this->assertFalse(Check::isPalindrome($string));
	}

	public function testIsAnagram(): void
	{
		$string1 = 'Yes';
		$string2 = 'No';
		$this->assertFalse(Check::isAnagram($string1, $string2));
		$this->assertFalse(Check::isAnagram($string1, $string2, true));

		$string1 = 'Yas';
		$string2 = 'Say';
		$this->assertTrue(Check::isAnagram($string1, $string2));

		$string1 = 'Some letters';
		$string2 = 'Letters some';
		$this->assertTrue(Check::isAnagram($string1, $string2));

		$string1 = 'Some letters';
		$string2 = 'Letterssome';
		$this->assertFalse(Check::isAnagram($string1, $string2, true));
	}

	public function testStrContains(): void
	{
		$haystack = 'This haystack has a needle.';
		$needle = 'needle';
		$this->assertTrue(Check::strContains($haystack, $needle));

		$haystack = 'This haystack has a pitchfork.';
		$this->assertFalse(Check::strContains($haystack, $needle));

		$needle = null;
		$this->assertTrue(Check::strContains($haystack, $needle));
		$this->assertFalse(Check::strContains($haystack, $needle, false));
	}
}
