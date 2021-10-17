<?php

namespace Tests\Unit\Date;

use PHPUnit\Framework\TestCase;
use App\libs\JPDateFormat;

class DateFormatTest extends TestCase
{
    /**
     * @test
     * 
     * php artisan make:test Date/DateFormatTest --unit
     * vendor/bin/phpunit tests/Unit/Date/JPDateFormatTest.php
     */

    public function testchgAdToJpDate()
    {
        $OB = new JPDateFormat;
        $str = $OB ->JPDateFormatStr('2021-10-16');
        $this->assertSame($str,'令和3年10月16日');
    }

    public function testchgAdToJpDateAry()
    {
        $OB = new JPDateFormat;
        $ary = $OB ->JPDateFormat('2021-10-16');
        $this->assertIsArray($ary);
        $this->assertArrayHaskey('G',$ary);
        $this->assertSame('R',$ary['G']);
        $this->assertEquals('R',$ary['G']);
      }





}
