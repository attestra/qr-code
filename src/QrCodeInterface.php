<?php

declare(strict_types=1);

namespace Attestra\QrCode;

use Attestra\QrCode\Color\ColorInterface;
use Attestra\QrCode\Encoding\EncodingInterface;
use Attestra\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelInterface;
use Attestra\QrCode\RoundBlockSizeMode\RoundBlockSizeModeInterface;

interface QrCodeInterface
{
    public function getData(): string;

    public function getEncoding(): EncodingInterface;

    public function getErrorCorrectionLevel(): ErrorCorrectionLevelInterface;

    public function getSize(): int;

    public function getMargin(): int;

    public function getRoundBlockSizeMode(): RoundBlockSizeModeInterface;

    public function getForegroundColor(): ColorInterface;

    public function getBackgroundColor(): ColorInterface;
}
