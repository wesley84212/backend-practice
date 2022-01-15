<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    use HasFactory;
    static function currencyTransform($currency, $transCurrency,$price ){
        $currenciseSource = '{"TWD":{"TWD":1,"JPY":3.669,"USD":0.03281},
                            "JPY":{"TWD":0.26956,"JPY":1,"USD":0.00885},
                            "USD":{"TWD":30.444,"JPY":111.801,"USD":1}}';
        $currenciseObj = json_decode($currenciseSource);
        $exchangeRate = $currenciseObj->$currency->$transCurrency;
        $result = $price * $exchangeRate;
        return number_format(round($result,2), 2);
    }
}
