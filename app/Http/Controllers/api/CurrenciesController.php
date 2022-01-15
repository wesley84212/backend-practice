<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\CurrencyCode;
use App\Models\Currencies;

class CurrenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function currencyTransform(Request $request)
    {
        $validator = $this->inputCheck($request);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $statusCode = 400;
            return response()->json($errors, $statusCode);
        }

        $data = $request->all();
        $currency = $data["currency"];
        $transCurrency = $data["transCurrency"];
        $price = $data["price"];
        $result = Currencies::currencyTransform($currency, $transCurrency,$price);
        return response()->json(['status' => 200, 'result' => $result]);
    }

    private function inputCheck($request)
    {
        $validator = Validator::make($request->all(), [
            'currency' => ['required', 'string', new CurrencyCode],
            'transCurrency' => ['required', 'string', new CurrencyCode],
            'price' => ['required', 'numeric']
        ]);
        return $validator;
    }
}
