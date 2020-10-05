<?php

use App\DTO\BinListDTO;
use PHPUnit\Framework\TestCase;
use App\Commission;
use App\Bin;
use App\Currency;

/**
 * Class CommissionTest
 */
class CommissionTest extends TestCase
{
    private Commission $commission;

    private array $results;

    /**
     * @var false|string
     */
    private $rates;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->rates = file_get_contents(__DIR__ . '/fixtures/rates/rates.txt');

        $this->results = [
            1,
            0.42625745950554,
            1.6207455429498,
            2.2165387894288,
            44.114565526673,
        ];
    }

    /**
     * @throws Exception
     */
    public function testCalculateCommission()
    {
        $commission = new Commission();
        $fileContent = $commission->getFileContent(['app.php', 'input.txt']);

        $i = 0;

        foreach ($fileContent as $key => $json) {
            $commission->setTransaction($json);
            $bin = $this->getMockBuilder(Bin::class)->getMock();
            $currency = $this->getMockBuilder(Currency::class)->getMock();
            $binResults = file_get_contents(__DIR__ . '/fixtures/bins/' . $commission->getTransaction()->getBin() . '.txt');
            $binList = new BinListDTO(json_decode($binResults, true));
            $rate = json_decode($this->rates, true)['rates'][$commission->getTransaction()->getCurrency()] ?? 0;

            $bin->expects($this->once())
                ->method('getList')
                ->willReturn($binList);

            $currency->expects($this->once())
                ->method('getRate')
                ->willReturn($rate);

            $commission->setBin($bin);
            $commission->setCurrency($currency);

            $this->assertSame((float) $this->results[$i], $commission->getResult($json));

            $i++;
        }
    }
}
