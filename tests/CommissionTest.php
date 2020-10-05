<?php

use PHPUnit\Framework\TestCase;
use App\Commission;

/**
 * Class CommissionTest
 */
class CommissionTest extends TestCase
{
    private Commission $commission;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->commission = $this->createMock(Commission::class);
    }

    /**
     * @throws Exception
     */
    public function testCalculateCommission()
    {

//        $map = [
//            1,
//            0.42625745950554,
//            1.6207455429498,
//            2.2165387894288,
//            44.114565526673,
//
//        ];
//
//        $observer = $this->getMockBuilder(Commission::class)
//
//            ->getMock();
//
//
//
//




        $commission = new Commission();

        $this->assertSame(3, $commission->getResult('{"bin":"45717360","amount":"100.00","currency":"EUR"}'));


    }


}