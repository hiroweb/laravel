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
        $this->assertSame(39,$age);
    }

    public function testFloorPerTime()
    {
        $lib = new CommonClass;
        $date = $lib ->floorPerTime('2021-10-16 17:24:00',5);
        $this->assertIsObject($date,true);
        $this->assertSame('2021-10-16 17:20:00',$date->format('Y-m-d H:i:s'));
    }

    public function testCeilPerTime()
    {
        $lib = new CommonClass;
        $date = $lib ->ceilPerTime('2021-10-16 17:24:00');
        $this->assertIsObject($date,True);
        $this->assertSame('2021-10-16 17:25:00',$date->format('Y-m-d H:i:s'));
    }


    public function testisNowBetween()
    {
        $lib = new CommonClass;
        $date1='2021-10-17 10:00:00';
        $date2='2021-10-17 13:30:00';

        $boole = $lib ->isNowBetween($date1,$date2);
        $this->assertSame(false,$boole);
    }


    public function testwhereIsNow()
    {
        $lib = new CommonClass;
        $date[]='2021-10-17 10:00:00';
        $date[]='0000-00-00 00:00:00';
        $date[]='2021-10-17 14:45:00';
        $date[]='2021-10-20 14:55:00';

        $num = $lib ->whereIsNow($date);
        $this->assertSame(2,$num);
    }

    /*ランダム文字列の衝突テスト （マイクロ秒*32767通りのランダム）*/
    public function testmkran32()
    {
        $randoms = array();
        $lib = new CommonClass;
        for ($i=0; $i < 99999; $i++) { 
            $randoms[]=$lib ->mkran32();
        }
        //$randoms[]=$randoms[0];
        $flag = $lib->isDuplicateArrayValue($randoms);
        $this->assertSame(false,$flag);
    }

    /*ランダム文字列の衝突テスト（長さ・数字・文字列指定） */
    public function testrandomstr()
    {
        $randoms = array();
        $lib = new CommonClass;
        for ($i=0; $i < 1000; $i++) { 
            $randoms[]=$lib ->randomstr(7,'123456789');
        }
        //$randoms[]=$randoms[0];
        $flag = $lib->isDuplicateArrayValue($randoms);
        $this->assertSame(false,$flag);
    }

    public function teststrm()
    {
        $lib = new CommonClass;
        $text='あいうえおかきくけこさしすせそたちつてと';
        $str = $lib ->strm($text,12,'…');
        $this->assertSame('あいうえおかきくけこさし…',$str);
    }





}
