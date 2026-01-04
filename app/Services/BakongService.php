<?php

namespace App\Services;

use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;
use KHQR\Models\MerchantInfo;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BakongService
{
    protected $merchantId;
    protected $merchantName;
    protected $merchantCity;

    public function __construct()
    {
        $this->merchantId = config('services.bakong.merchant_id', 'soriya_chann@bkrt');
        $this->merchantName = config('services.bakong.merchant_name', 'Chrey Shop');
        $this->merchantCity = config('services.bakong.merchant_city', 'PHNOM PENH');
    }

    /**
     * Generate KHQR code for payment
     *
     * @param array $data
     * @return array|null
     */
    public function generateKHQR($data)
    {
        try {
            // Create merchant info for KHQR generation
            // Currency: KHQRData::CURRENCY_USD (840) for USD, KHQRData::CURRENCY_KHR (116) for Riel
            $marchant = new IndividualInfo(
                bakongAccountID: $this->merchantId,
                merchantName: $this->merchantName,
                merchantCity: $this->merchantCity,
                currency: KHQRData::CURRENCY_USD, // USD payment
                amount: (float) $data['amount'],
            );

            // Generate KHQR string
            $khqrResponse = BakongKHQR::generateIndividual($marchant);

            // Check if generation was successful
            if ($khqrResponse->status['code'] !== 0) {
                return null;
            }

            // Access data directly from the response object
            if (!isset($khqrResponse->data['qr'])) {
                return null;
            }

            $khqrString = $khqrResponse->data['qr'];
            $md5Hash = $khqrResponse->data['md5'] ?? null;

            // Generate QR code as SVG (no imagick extension required)
            $qrCodeSvg = QrCode::format('svg')
                ->size(300)
                ->generate($khqrString);

            // Explicitly convert to string to avoid any object issues
            $qrCodeSvgString = (string) $qrCodeSvg;

            return [
                'qr' => $qrCodeSvgString,
                'khqr_string' => $khqrString,
                'md5' => $md5Hash,
                'transactionId' => 'KHQR-' . strtoupper(uniqid()),
                'id' => 'khqr-payment-' . time(),
                'status' => 'pending',
            ];
        } catch (\Exception $e) {
            Log::error('Bakong KHQR generation error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return null;
        }
    }

    /**
     * Check payment status
     *
     * @param string $transactionId
     * @return array|null
     */
    public function checkPaymentStatus(string $md5)
    {
        $token = env('BAKONG_TOKEN');
        $bakong = new BakongKHQR($token);

        $response = $bakong->checkTransactionByMD5($md5);

        // API-level error
        if ($response['status']['code'] !== 0) {
            return [
                'status' => 'error',
                'message' => $response['status']['message']
            ];
        }

        // Payment status from Bakong
        return [
            'status' => strtolower($response['data']['status']), // success | pending | failed
            'transaction_id' => $response['data']['transactionId'] ?? null,
            'amount' => $response['data']['amount'] ?? null,
            'currency' => $response['data']['currency'] ?? null
        ];
    }
}
