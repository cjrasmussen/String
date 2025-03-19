<?php

namespace cjrasmussen\Tests;

use cjrasmussen\String\Convert;
use PHPUnit\Framework\TestCase;

class ConvertTest extends TestCase
{
	public function testPossessive(): void
	{
		$string = 'Steve';
		$expected = 'Steve\'s';
		$this->assertEquals($expected, Convert::possessive($string));

		$string = 'James';
		$expected = 'James\'';
		$this->assertEquals($expected, Convert::possessive($string));
	}

	public function testNullToDash(): void
	{
		$string = 'Not null';
		$this->assertEquals($string, Convert::nullToDash($string));
		$this->assertEquals($string, Convert::nullToDash($string, '--'));

		$string = null;
		$expected = '&mdash;';
		$this->assertEquals($expected, Convert::nullToDash($string));

		$expected = '--';
		$this->assertEquals($expected, Convert::nullToDash($string, $expected));
	}

	public function testBooleanToYesNo(): void
	{
		$expected = 'No';
		$input = false;
		$this->assertEquals($expected, Convert::booleanToYesNo($input));

		$input = 0;
		$this->assertEquals($expected, Convert::booleanToYesNo($input));

		$input = null;
		$this->assertEquals($expected, Convert::booleanToYesNo($input));

		$input = '0';
		$this->assertEquals($expected, Convert::booleanToYesNo($input));

		$expected = 'Yes';
		$input = true;
		$this->assertEquals($expected, Convert::booleanToYesNo($input));

		$input = 1;
		$this->assertEquals($expected, Convert::booleanToYesNo($input));

		$input = '1';
		$this->assertEquals($expected, Convert::booleanToYesNo($input));

		$input = 'tacos';
		$this->assertEquals($expected, Convert::booleanToYesNo($input));

		$input = 2013;
		$this->assertEquals($expected, Convert::booleanToYesNo($input));
	}
}
