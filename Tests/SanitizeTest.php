<?php

namespace cjrasmussen\Tests;

use cjrasmussen\String\Sanitize;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class SanitizeTest extends TestCase
{
	public function testSqlIdentifier(): void
	{
		$string = 'safeFieldName';
		$expected = 'safeFieldName';
		$this->assertEquals($expected, Sanitize::sqlIdentifier($string));

		$string = 'Robert\'); DROP TABLE students;--';
		$expected = 'Robert\\\'); DROP TABLE students';
		$this->assertEquals($expected, Sanitize::sqlIdentifier($string));
	}

	public function testHashtagList(): void
	{
		$string = '#HashtagOne HashtagTwo #Hashtag3';
		$expected = '#HashtagOne #HashtagTwo #Hashtag3';
		$this->assertEquals($expected, Sanitize::hashtagList($string));

		$string = '#HashtagOne; HashtagTwo;#Hashtag3';
		$expected = '#HashtagOne;#HashtagTwo;#Hashtag3';
		$this->assertEquals($expected, Sanitize::hashtagList($string, ';'));
	}

	public function testHashtagList_ExceptionInvalidSeparator(): void
	{
		$this->expectException(InvalidArgumentException::class);

		$string = '#HashtagOne HashtagTwo #Hashtag3';
		$expected = '#HashtagOne #HashtagTwo #Hashtag3';
		$this->assertEquals($expected, Sanitize::hashtagList($string, '!'));
	}
}
