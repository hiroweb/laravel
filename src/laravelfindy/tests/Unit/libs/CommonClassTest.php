<?php

namespace Tests\Unit\libs;

use PHPUnit\Framework\TestCase;
use App\libs\CommonClass;

class CommonClassTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     * php artisan make:test libs/CommonClassTest --unit
     * vendor/bin/phpunit tests/Unit/libs/CommonClassTest.php
     */
    public function testChkDate()
    {
        $lib = new CommonClass;
        $flag = $lib ->chkDate('2021-10-16');
        $this->assertTrue($flag);
    }

    public function testHowOld()
    {
        $lib = new CommonClass;
        $age = $lib ->howOld('1981-12-23');
        $this->assertSame($age,39);
    }

    public function testFloorPerTime()
    {
        $lib = new CommonClass;
        $date = $lib ->floorPerTime('2021-10-16 17:24:00');
        $this->assertIsObject($date,True);
        $this->assertSame($date->format('Y-m-d H:i:s'),'2021-10-16 17:20:00');
    }

    public function testCeilPerTime()
    {
        $lib = new CommonClass;
        $date = $lib ->ceilPerTime('2021-10-16 17:24:00');
        $this->assertIsObject($date,True);
        $this->assertSame($date->format('Y-m-d H:i:s'),'2021-10-16 17:25:00');
    }

    public function teststrm()
    {
        $lib = new CommonClass;
        $text='あいうえおかきくけこさしすせそたちつてと';
        $str = $lib ->strm($text,12,'…');
        $this->assertSame($str,'あいうえおかきくけこさし…');
    }


}
