<?php

namespace App\Support;

class PaymentStatus
{
    public const SUCCESS = 'SUCCESS';
    public const FAILED = 'FAILED';
    public const PROCESSING = 'PROCESSING';
    public const PENDING = 'PENDING';
    public const PAID = 'PAID';

    public static function normalize(?string $status): string
    {
        $value = strtoupper(trim((string) $status));

        return match ($value) {
            'SUCCESS', 'SUCCEEDED', 'COMPLETED', self::PAID => self::SUCCESS,
            'FAILED', 'FAIL', 'ERROR', 'DECLINED', 'CANCELLED' => self::FAILED,
            'PROCESSING', self::PENDING, 'INITIATED', 'IN_PROGRESS' => self::PROCESSING,
            default => self::PROCESSING,
        };
    }

    public static function successValues(): array
    {
        return [self::SUCCESS, self::PAID];
    }

    public static function processingValues(): array
    {
        return [self::PROCESSING, self::PENDING];
    }
}

