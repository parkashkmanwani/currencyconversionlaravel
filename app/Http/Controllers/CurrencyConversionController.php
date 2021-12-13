<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthenticateService;
use App\Services\CurrencyLayerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CurrencyConversionController extends Controller
{
    /**
     * @var CurrencyLayerService
     */
    protected CurrencyLayerService $currencyLayerService;

    /**
     * CurrencyConversionController Constructor
     *
     * @param CurrencyLayerService $currencyLayerService
     *
     */
    public function __construct(CurrencyLayerService $currencyLayerService)
    {
        $this->currencyLayerService = $currencyLayerService;
    }

    /**
     *
     * Currency Conversion Rates
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function getRates(Request $request): JsonResponse
    {
        [$data, $statusCode] = $this->currencyLayerService->getCurrencyConversion($request['currencies']);

        return response()->json($data, $statusCode);
    }

    /**
     *
     * Get Currencies
     *
     * @return JsonResponse
     */
    public function getCurrencies(): JsonResponse
    {
        [$data, $statusCode] = $this->currencyLayerService->getCurrencies();

        return response()->json($data, $statusCode);
    }

    /**
     *
     * Get Historical Data
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getHistorical(Request $request): JsonResponse
    {
        [$data, $statusCode] = $this->currencyLayerService->getHistoricalData($request['currencies'], $request['date']);

        return response()->json($data, $statusCode);
    }
}
