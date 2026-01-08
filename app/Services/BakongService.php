<?php

namespace App\Services;

use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * Bakong KHQR Payment Service
 *
 * Handles Bakong KHQR (Khmer QR) payment integration for generating QR codes
 * and verifying payment status through the National Bank of Cambodia's Bakong system.
 *
 * @package App\Services
 * @version 1.0.0
 *
 * Configuration (.env):
 * - BAKONG_API_KEY: API token from Bakong (required for production)
 * - BAKONG_MERCHANT_ID: Merchant Bakong account ID (e.g., merchant@bank)
 * - BAKONG_TEST_MODE: Set to true for development/testing (auto-approves payments)
 *
 * Usage Example:
 * ```php
 * $bakong = app(BakongService::class);
 *
 * // Generate QR code
 * $payment = $bakong->generateKHQR(['amount' => 10.50]);
 * // Returns: ['qr' => '<svg>...</svg>', 'md5' => 'abc123...', ...]
 *
 * // Check payment status
 * $status = $bakong->checkPaymentStatus('abc123...');
 * // Returns: ['status' => 'success', 'amount' => 10.50, ...]
 * ```
 */
class BakongService
{
    /**
     * Bakong merchant account ID
     * @var string
     */
    protected $merchantId;

    /**
     * Merchant display name
     * @var string
     */
    protected $merchantName;

    /**
     * Merchant city/location
     * @var string
     */
    protected $merchantCity;

    /**
     * Initialize Bakong service with merchant configuration
     */
    public function __construct()
    {
        $this->merchantId = config('services.bakong.merchant_id', 'soriya_chann@bkrt');
        $this->merchantName = config('services.bakong.merchant_name', 'Chrey Shop');
        $this->merchantCity = config('services.bakong.merchant_city', 'PHNOM PENH');
    }

    /**
     * Generate KHQR payment QR code
     *
     * Creates a Khmer QR (KHQR) code for payment through the Bakong system.
     * The QR code can be scanned by any Bakong-compatible banking app.
     *
     * @param array $data Payment data
     *   - amount (float|int): Payment amount in USD (required)
     *
     * @return array|null Array containing:
     *   - qr (string): SVG QR code as string
     *   - khqr_string (string): Raw KHQR data string
     *   - md5 (string): Unique transaction identifier for status checking
     *   - transactionId (string): Internal transaction reference
     *   - id (string): Payment session identifier
     *   - status (string): Initial status ('pending')
     *
     * @example
     * ```php
     * $payment = $bakong->generateKHQR(['amount' => 25.00]);
     * if ($payment) {
     *     echo $payment['qr']; // Display QR code
     *     $md5 = $payment['md5']; // Store for status checking
     * }
     * ```
     */
    public function generateKHQR(array $data): ?array
    {
        try {
            $merchant = new IndividualInfo(
                bakongAccountID: $this->merchantId,
                merchantName: $this->merchantName,
                merchantCity: $this->merchantCity,
                currency: KHQRData::CURRENCY_USD,
                amount: (float) $data['amount'],
            );

            $khqrResponse = BakongKHQR::generateIndividual($merchant);

            if ($khqrResponse->status['code'] !== 0 || !isset($khqrResponse->data['qr'])) {
                return null;
            }

            $qrCodeSvg = QrCode::format('svg')
                ->size(300)
                ->generate($khqrResponse->data['qr']);

            return [
                'qr' => (string) $qrCodeSvg,
                'khqr_string' => $khqrResponse->data['qr'],
                'md5' => $khqrResponse->data['md5'] ?? null,
                'transactionId' => 'KHQR-' . strtoupper(uniqid()),
                'id' => 'khqr-payment-' . time(),
                'status' => 'pending',
            ];
        } catch (\Exception $e) {
            Log::error('Bakong KHQR generation failed', [
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Check payment status by MD5 transaction hash
     *
     * Queries the Bakong API to verify if a payment has been completed.
     * In production, checks with Bakong's servers. In test mode, auto-approves.
     *
     * @param string $md5 Unique transaction identifier from generateKHQR()
     *
     * @return array Payment status data:
     *   - status (string): Payment state
     *     - 'success': Payment completed successfully
     *     - 'pending': Payment not yet received or transaction not found
     *     - 'error': API error or configuration issue
     *   - transaction_id (string|null): Bakong transaction hash
     *   - amount (float|null): Paid amount in USD
     *   - currency (string|null): Payment currency code ('USD')
     *   - message (string|null): Error or status message
     *
     * @example
     * ```php
     * $status = $bakong->checkPaymentStatus('abc123...');
     *
     * if ($status['status'] === 'success') {
     *     // Payment confirmed - create order
     *     $amount = $status['amount'];
     * } elseif ($status['status'] === 'pending') {
     *     // Still waiting for payment
     * }
     * ```
     *
     * @see generateKHQR() For obtaining the MD5 hash
     */
    public function checkPaymentStatus(string $md5): array
    {
        try {
            $token = env('BAKONG_API_KEY');

            if (!$token) {
                Log::error('Bakong API key not configured');
                return ['status' => 'error', 'message' => 'Payment service not configured'];
            }

            $bakong = new BakongKHQR($token);
            $response = $bakong->checkTransactionByMD5($md5);

            $responseCode = $response['responseCode'] ?? $response['status']['code'] ?? null;

            // responseCode 0 = Transaction found (payment successful)
            // responseCode 1 = Transaction not found (pending)
            if ($responseCode !== 0) {
                return [
                    'status' => 'pending',
                    'message' => $response['responseMessage'] ?? 'Transaction not found'
                ];
            }

            // Payment successful
            if (!empty($response['data'])) {
                return [
                    'status' => 'success',
                    'transaction_id' => $response['data']['hash'] ?? $response['data']['externalRef'] ?? null,
                    'amount' => $response['data']['amount'] ?? null,
                    'currency' => $response['data']['currency'] ?? null
                ];
            }

            return ['status' => 'pending', 'message' => 'Unexpected response format'];
        } catch (\Exception $e) {
            Log::error('Bakong payment check failed', [
                'error' => $e->getMessage(),
                'md5' => $md5
            ]);

            return ['status' => 'error', 'message' => 'Failed to check payment status'];
        }
    }
}
