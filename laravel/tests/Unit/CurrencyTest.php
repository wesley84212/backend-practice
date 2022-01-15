<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Currencies;

class currency extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_twdtoother()
    {
        $currency = "TWD";
        $transCurrency = ["TWD", "JPY", "USD"];
        $price = 10;
        $resultArray = [];
        for ($i = 0; $i < count($transCurrency); $i++) {
            array_push($resultArray, Currencies::currencyTransform($currency, $transCurrency[$i], $price));
        }
        $this->assertEquals($resultArray[0], 10);
        $this->assertEquals($resultArray[1], 36.69);
        $this->assertEquals($resultArray[2], 0.33);
    }
    public function test_jpytoother()
    {
        $currency = "JPY";
        $transCurrency = ["TWD", "JPY", "USD"];
        $price = 10;
        $resultArray = [];
        for ($i = 0; $i < count($transCurrency); $i++) {
            array_push($resultArray, Currencies::currencyTransform($currency, $transCurrency[$i], $price));
        }
        $this->assertEquals($resultArray[0], 2.70);
        $this->assertEquals($resultArray[1], 10);
        $this->assertEquals($resultArray[2], 0.09);
    }
    public function test_usdtoother()
    {
        $currency = "USD";
        $transCurrency = ["TWD", "JPY", "USD"];
        $price = 10;
        $resultArray = [];
        for ($i = 0; $i < count($transCurrency); $i++) {
            array_push($resultArray, Currencies::currencyTransform($currency, $transCurrency[$i], $price));
        }
        $this->assertEquals($resultArray[0], 304.44);
        $this->assertEquals($resultArray[1], "1,118.01");
        $this->assertEquals($resultArray[2], 10);
    }
    public function test_checkdecimal()
    {
        $currency = "TWD";
        $transCurrency = "USD";
        $price = 1;
        $result = Currencies::currencyTransform($currency, $transCurrency, $price);
        $this->assertEquals($result, 0.03);
    }
    public function test_checkthousands()
    {
        $currency = "TWD";
        $transCurrency = "JPY";
        $price = 10000;
        $result = Currencies::currencyTransform($currency, $transCurrency, $price);
        $this->assertEquals($result, "36,690.00");
    }
}
