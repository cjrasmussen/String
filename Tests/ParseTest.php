<?php

namespace cjrasmussen\Tests;

use cjrasmussen\String\Parse;
use PHPUnit\Framework\TestCase;

class ParseTest extends TestCase
{
	public function testFilterChars(): void
	{
		$string = 'L3tt3r5&numb3r5!';
		$expected = 'L3tt3r5numb3r5';
		$this->assertEquals($expected, Parse::filterChars($string));

		$expected = 'Lttrnumbr';
		$this->assertEquals($expected, Parse::filterChars($string, Parse::FILTER_ALPHA));

		$expected = '33535';
		$this->assertEquals($expected, Parse::filterChars($string, Parse::FILTER_NUM));
	}

	public function testGetUrls(): void
	{
		$string = 'One URL in this string is https://cjr.dev and another is https://php.net.';
		$expected = [
			(object)[
				'url' => 'https://cjr.dev',
				'start' => 26,
				'end' => 41,
			],
			(object)[
				'url' => 'https://php.net',
				'start' => 57,
				'end' => 72,
			],
		];
		$this->assertEquals($expected, Parse::getUrls($string));

		$string = 'There are no URLs in this string.';
		$expected = [];
		$this->assertEquals($expected, Parse::getUrls($string));
	}

	public function testGetHashtags(): void
	{
		$string = 'One hashtag in this string is #TestingInProduction and the other is #PHPIsNotDead.';
		$expected = [
			(object)[
				'hashtag' => '#TestingInProduction',
				'text' => 'TestingInProduction',
				'start' => 30,
				'end' => 50,
			],
			(object)[
				'hashtag' => '#PHPIsNotDead',
				'text' => 'PHPIsNotDead',
				'start' => 68,
				'end' => 81,
			],
		];
		$this->assertEquals($expected, Parse::getHashtags($string));

		$string = 'There are no hashtags in this string.';
		$expected = [];
		$this->assertEquals($expected, Parse::getHashtags($string));
	}

	public function testGetLazyIndefiniteArticle(): void
	{
		$string = 'taco';
		$expected = 'a';
		$this->assertEquals($expected, Parse::getLazyIndefiniteArticle($string));

		$string = 'race car';
		$this->assertEquals($expected, Parse::getLazyIndefiniteArticle($string));

		$string = 'bathtub';
		$this->assertEquals($expected, Parse::getLazyIndefiniteArticle($string));

		$string = 'avacado';
		$expected = 'an';
		$this->assertEquals($expected, Parse::getLazyIndefiniteArticle($string));

		$string = 'onion';
		$this->assertEquals($expected, Parse::getLazyIndefiniteArticle($string));

		$string = 'elephant';
		$this->assertEquals($expected, Parse::getLazyIndefiniteArticle($string));

		$string = 'umbrella';
		$this->assertEquals($expected, Parse::getLazyIndefiniteArticle($string));

		$string = 'illness';
		$this->assertEquals($expected, Parse::getLazyIndefiniteArticle($string));
	}
}
