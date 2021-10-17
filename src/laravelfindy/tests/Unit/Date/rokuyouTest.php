<?php

namespace Tests\Unit\Date;
use PHPUnit\Framework\TestCase;
use App\libs\Rokuyou;

class rokuyouTest extends TestCase
{
    /**
     * @test
     * 
     * php artisan make:test Date/rokuyouTest --unit
     * vendor/bin/phpunit tests/Unit/Date/RokuyouTest.php
     * 
     */
    public function testKyureki()
    {
        $rokuyou = new Rokuyou;
        $day = $rokuyou ->calc_kyureki('2021','10','16');
        $this->assertSame($day[1],0);
        $this->assertSame($day[2],9.0);
        $this->assertSame($day[3],11.0);
    }

    public function testRokuyou()
    {
        $rokuyou = new Rokuyou;
        $day = $rokuyou ->get_rokuyou('2021','10','16');
        $this->assertSame($day,2);
    }

}
