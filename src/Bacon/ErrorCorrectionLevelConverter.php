<?php

declare(strict_types=1);

namespace Attestra\QrCode\Bacon;

use BaconQrCode\Common\ErrorCorrectionLevel;
use Attestra\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Attestra\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelInterface;
use Attestra\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Attestra\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelMedium;
use Attestra\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelQuartile;

final class ErrorCorrectionLevelConverter
{
    public static function convertToBaconErrorCorrectionLevel(ErrorCorrectionLevelInterface $errorCorrectionLevel): ErrorCorrectionLevel
    {
        if ($errorCorrectionLevel instanceof ErrorCorrectionLevelLow) {
            return ErrorCorrectionLevel::valueOf('L');
        } elseif ($errorCorrectionLevel instanceof ErrorCorrectionLevelMedium) {
            return ErrorCorrectionLevel::valueOf('M');
        } elseif ($errorCorrectionLevel instanceof ErrorCorrectionLevelQuartile) {
            return ErrorCorrectionLevel::valueOf('Q');
        } elseif ($errorCorrectionLevel instanceof ErrorCorrectionLevelHigh) {
            return ErrorCorrectionLevel::valueOf('H');
        }

        throw new \Exception('Error correction level could not be converted');
    }
}
