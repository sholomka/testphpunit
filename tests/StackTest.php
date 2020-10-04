<?php

use PHPUnit\Framework\TestCase;
use App\Commission;

class StackTest extends TestCase
{
    private Commission $commission;

    public function setUp(): void
    {

        $argv = ['app.php', 'input.txt'];

        $this->commission = new Commission($argv);
    }


    public function testPushAndPop()
    {

        $this->commission->calculate();

        $stack = [];
        $this->assertSame(0, count($stack));

        array_push($stack, 'foo');
        $this->assertSame('foo', $stack[count($stack)-1]);
        $this->assertSame(1, count($stack));

        $this->assertSame('foo', array_pop($stack));
        $this->assertSame(0, count($stack));
    }
}