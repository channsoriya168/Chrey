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
            // Determine currency code (840 = USD, 116 = KHR)
            $currencyCode = null;
            if (isset($data['currency'])) {
                $currencyCode = strtoupper($data['currency']) === 'USD' ? 840 : 116;
            }

            $marchant = new IndividualInfo(
                bakongAccountID: $this->merchantId,
                merchantName: $this->merchantName,
                merchantCity: $this->merchantCity,
                currency: $currencyCode,
                amount: (float) $data['amount'],
            );

            // Generate KHQR string
            $khqrResponse = BakongKHQR::generateIndividual($marchant);

            // Check if generation was successful
            if ($khqrResponse->status['code'] !== 0) {
                Log::error('Bakong KHQR generation failed', [
                    'status' => $khqrResponse->status,
                    'response' => (string) $khqrResponse
                ]);
                return null;
            }

            // Access data directly from the response object
            if (!isset($khqrResponse->data['qr'])) {
                Log::error('Bakong KHQR generation failed - no QR in response', [
                    'response' => (string) $khqrResponse
                ]);
                return null;
            }

            $khqrString = $khqrResponse->data['qr'];
            $md5Hash = $khqrResponse->data['md5'] ?? null;

            // Generate QR code as SVG (no imagick extension required)
            $qrCodeSvg = QrCode::format('svg')
                ->size(300)
                ->generate($khqrString);

            Log::info('Bakong KHQR Response', [
                'khqr_generated' => !empty($khqrString),
                'qr_svg_generated' => !empty($qrCodeSvg),
                'md5' => $md5Hash
            ]);

            return [
                'qr' => $qrCodeSvg,
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
    public function checkPaymentStatus($transactionId)
    {
        try {
            // For KHQR, payment status needs to be checked via webhook or manual verification
            // This is a placeholder that returns pending status
            return [
                'status' => 'pending',
                'transactionId' => $transactionId
            ];
        } catch (\Exception $e) {
            Log::error('Bakong payment status check error', [
                'message' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Verify webhook signature
     *
     * @param array $payload
     * @param string $signature
     * @return bool
     */
    public function verifyWebhookSignature($payload, $signature)
    {
        $apiKey = config('services.bakong.api_key');
        $expectedSignature = hash_hmac('sha256', json_encode($payload), $apiKey);
        return hash_equals($expectedSignature, $signature);
    }
}
