<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\AuthenticateRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Http\Request;
use Exception;

class CurrencyLayerService extends BaseService
{
    /**
     * Get Currency Conversions
     *
     * @param string $currencies
     *
     * @return array
     */
    public function getCurrencyConversion(string $currencies): array
    {
        try {
            $rates = $this->callEndpoint('live', $currencies);
            $newcurrencyarray = array();

            $i = 0;
            foreach($rates['quotes'] as $quote) {
                $newcurrencyarray[] = [
                    'rate' => array_values($rates['quotes'])[$i],
                    'name' => array_keys($rates['quotes'])[$i]
                ];
                $i++;
            }

            return $this->sendSuccessResponse($newcurrencyarray);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->sendFailureResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Get Historical Currency Data
     *
     * @param string $currencies
     *
     * @return array
     */
    public function getHistoricalData(string $currencies, string $date): array
    {
        try {
            $rates = $this->callEndpoint('historical', $currencies, $date);
            $newcurrencyarray = array();

            $i = 0;
            foreach($rates['quotes'] as $quote) {
                $newcurrencyarray[] = [
                    'rate' => array_values($rates['quotes'])[$i],
                    'name' => array_keys($rates['quotes'])[$i]
                ];
                $i++;
            }

            return $this->sendSuccessResponse($newcurrencyarray);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->sendFailureResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Get All Currencies
     *
     * @return array
     */
    public function getCurrencies(): array
    {
        try {
            $currencies = $this->callEndpoint('list');
            $newcurrencyarray = array();

            $i = 0;
            foreach($currencies['currencies'] as $curr) {
                $newcurrencyarray[] = [
                    'name' => array_values($currencies['currencies'])[$i],
                    'code' => array_keys($currencies['currencies'])[$i]
                ];
                $i++;
            }

            return $this->sendSuccessResponse($newcurrencyarray);

        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->sendFailureResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Call Currency Layer Endpoint
     *
     * @param string $endpoint
     * @param string $currencies
     *
     * @return string
     */
    public function callEndpoint(string $endpoint, string $currencies = '', string $date = null)
    {
        // set API Endpoint and access key (and any options of your choice)
        $access_key = env('CURRENCYLAYER_API_KEY');

        // Initialize CURL:
        if ($date)
        {
            $ch = curl_init('http://api.currencylayer.com/'.$endpoint.'?access_key='.$access_key.'&currencies='. $currencies .'&format=1'.'&date='.$date);
        }
        else
        {
            $ch = curl_init('http://api.currencylayer.com/'.$endpoint.'?access_key='.$access_key.'&currencies='. $currencies .'&format=1');
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $exchangeRates = json_decode($json, true);

        return $exchangeRates;

    }
}
