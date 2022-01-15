<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_checkbaseinput()
    {
        $testData = [
            "currency" => 123,
            "transCurrency" => 321,
            "price" => "test"
        ];
        json_encode($testData);
        $response = $this->post('/api/transfer', $testData);
        $this->assertEquals($response->json()["currency"][0],"The currency must be a string.");
        $this->assertEquals($response->json()["transCurrency"][0],"The trans currency must be a string.");
        $this->assertEquals($response->json()["price"][0],"The price must be a number.");
        $response->assertStatus(400);
    }

    public function test_checkcurrencycode(){
        $testData = [
            "currency" => "TDW",
            "transCurrency" => "JTP",
            "price" => 10
        ];
        json_encode($testData);
        $response = $this->post('/api/transfer', $testData);
        $this->assertEquals($response->json()["currency"][0],"The currency or transCurrency need in TWD,JPY,USD");
        $this->assertEquals($response->json()["transCurrency"][0],"The currency or transCurrency need in TWD,JPY,USD");
        $response->assertStatus(400);
    }
    public function test_checkemptydata(){
        $testData = [

        ];
        json_encode($testData);
        $response = $this->post('/api/transfer', $testData);
        $this->assertEquals($response->json()["currency"][0],"The currency field is required.");
        $this->assertEquals($response->json()["transCurrency"][0],"The trans currency field is required.");
        $this->assertEquals($response->json()["price"][0],"The price field is required.");
        $response->assertStatus(400);
    }
}
