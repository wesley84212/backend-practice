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
     * @OA\Post(
     *      path="/api/transfer",
     *      operationId="currencyTransfer",
     *      tags={"Currency"},
     *      summary="貨幣轉換",
     *      description="貨幣轉換",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="currency",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="transCurrency",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="price",
     *                      type="number"
     *                  ),
     *                  example={
     *                      "currency":"TWD",
     *                      "transCurrency":"USD",
     *                      "price": 10
     *                  }
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *         response="200",
     *         description="success",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="string",
     *                         description="The response status"
     *                     ),
     *                     @OA\Property(
     *                         property="result",
     *                         type="string|number",
     *                         description="The response price transfer"
     *                     ),
     *                     example={
     *                         "status": 200,
     *                         "result": "0.33"
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="error",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="status",
     *                         type="string",
     *                         description="The response status"
     *                     ),
     *                     @OA\Property(
     *                         property="errorMsg",
     *                         type="object",
     *                         description="error message"
     *                     ),
     *                     example={"status": "error",
     *                              "errorMsg": {
     *                                  "currency": [
     *                                       "The currency or transCurrency need in TWD,JPY,USD"
     *                                    ]
     *                             }
     *                 )
     *             )
     *         }
     *     )
     * )
     */

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
            $errorMsg = [
                "status" => "error",
                "errorMsg" => $errors
            ];
            return response()->json($errorMsg, $statusCode);
        }

        $data = $request->all();
        $currency = $data["currency"];
        $transCurrency = $data["transCurrency"];
        $price = $data["price"];
        $result = Currencies::currencyTransform($currency, $transCurrency, $price);
        return response()->json(['status' => "success", 'result' => $result]);
    }

    private function inputCheck($request)
    {
        $validator = Validator::make($request->all(), [
            'currency' => ['required', 'string', new CurrencyCode],
            'transCurrency' => ['required', 'string', new CurrencyCode],
            'price' => ['required', 'numeric','min:0','not_in:0']
        ]);
        return $validator;
    }
}
