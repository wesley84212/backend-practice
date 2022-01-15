<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\CurrencyCode;
use App\Rules\InputAttribute;

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
    public function store(Request $request)
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
        $currenciseSource = '{"TWD":{"TWD":1,"JPY":3.669,"USD":0.03281},"JPY":{"TWD":0.26956,"JPY":1,"USD":0.00885},"USD":{"TWD":30.444,"JPY":111.801,"USD":1}}';
        $currenciseObj = json_decode($currenciseSource);
        $exchangeRate = $currenciseObj->$currency->$transCurrency;
        $result = $price * $exchangeRate;
        return response()->json(['status' => 200, 'result' => number_format($result, 2)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
