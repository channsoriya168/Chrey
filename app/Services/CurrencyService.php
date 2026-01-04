<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyService
{
    public static function usdToKhr($usd)
    {
        // Cache rate for 30 minutes (avoid API limit)
        $rate = Cache::remember('usd_khr_rate', 1800, function () {
            $response = Http::get(
                'https://v6.exchangerate-api.com/v6/' .
                    config('services.exchange.api_key') .
                    '/latest/USD'
            );

            if ($response->successful()) {
                return $response->json()['conversion_rates']['KHR'];
            }

            return 4050; // fallback safety
        });

        return round($usd * $rate);
    }
}
