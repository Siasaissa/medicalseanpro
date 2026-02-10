<?php
namespace App\Services;

class ZegoToken
{
    /**
     * Generate token for ZEGOCLOUD UIKit Prebuilt
     * UIKit uses a simpler token format than RTC SDK
     */
    public static function generateKitToken($appId, $serverSecret, $roomId, $userId, $userName, $expireSeconds = 3600)
    {
        $currentTime = time();
        $expireTime = $currentTime + $expireSeconds;
        
        // UIKit Prebuilt token payload (simplified structure)
        $payload = [
            'app_id' => $appId,
            'user_id' => $userId,
            'nonce' => mt_rand(1000000000, 9999999999),
            'ctime' => $currentTime,
            'expire' => $expireTime
        ];

        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        // Encode
        $headerEncoded = self::base64UrlEncode(json_encode($header));
        $payloadEncoded = self::base64UrlEncode(json_encode($payload));
        
        // Sign
        $signature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", $serverSecret, true);
        $signatureEncoded = self::base64UrlEncode($signature);
        
        return "$headerEncoded.$payloadEncoded.$signatureEncoded";
    }

    /**
     * Alternative: Generate token using the "04" token format
     * This is specifically for UIKit Prebuilt
     */
    public static function generateToken04($appId, $userId, $serverSecret, $expireSeconds, $payload = '')
    {
        $time = time();
        $body = [
            'app_id' => $appId,
            'user_id' => $userId,
            'nonce' => $time * 1000 + mt_rand(0, 999),
            'ctime' => $time,
            'expire' => $time + $expireSeconds,
            'payload' => $payload
        ];

        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $headerEncoded = self::base64UrlEncode(json_encode($header));
        $bodyEncoded = self::base64UrlEncode(json_encode($body));
        
        $signature = hash_hmac('sha256', "$headerEncoded.$bodyEncoded", $serverSecret, true);
        $signatureEncoded = self::base64UrlEncode($signature);
        
        return '04' . "$headerEncoded.$bodyEncoded.$signatureEncoded";
    }

    private static function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}