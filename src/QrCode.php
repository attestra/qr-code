<?php

declare(strict_types=1);

namespace Attestra\QrCode;

use Attestra\QrCode\Color\Color;
use Attestra\QrCode\Color\ColorInterface;
use Attestra\QrCode\Encoding\Encoding;
use Attestra\QrCode\Encoding\EncodingInterface;
use Attestra\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelInterface;
use Attestra\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Attestra\QrCode\RoundBlockSizeMode\RoundBlockSizeModeInterface;
use Attestra\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;

final class QrCode implements QrCodeInterface
{
    private string $data;
    private EncodingInterface $encoding;
    private ErrorCorrectionLevelInterface $errorCorrectionLevel;
    private int $size;
    private int $margin;
    private RoundBlockSizeModeInterface $roundBlockSizeMode;
    private ColorInterface $foregroundColor;
    private ColorInterface $backgroundColor;

    public function __construct(
        string $data,
        EncodingInterface $encoding = null,
        ErrorCorrectionLevelInterface $errorCorrectionLevel = null,
        int $size = 300,
        int $margin = 10,
        RoundBlockSizeModeInterface $roundBlockSizeMode = null,
        ColorInterface $foregroundColor = null,
        ColorInterface $backgroundColor = null
    ) {
        $this->data = $data;
        $this->encoding = $encoding ?? new Encoding('UTF-8');
        $this->errorCorrectionLevel = $errorCorrectionLevel ?? new ErrorCorrectionLevelLow();
        $this->size = $size;
        $this->margin = $margin;
        $this->roundBlockSizeMode = $roundBlockSizeMode ?? new RoundBlockSizeModeMargin();
        $this->foregroundColor = $foregroundColor ?? new Color(0, 0, 0);
        $this->backgroundColor = $backgroundColor ?? new Color(255, 255, 255);
    }

    public static function create(string $data): self
    {
        return new self($data);
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getEncoding(): EncodingInterface
    {
        return $this->encoding;
    }

    public function setEncoding(Encoding $encoding): self
    {
        $this->encoding = $encoding;

        return $this;
    }

    public function getErrorCorrectionLevel(): ErrorCorrectionLevelInterface
    {
        return $this->errorCorrectionLevel;
    }

    public function setErrorCorrectionLevel(ErrorCorrectionLevelInterface $errorCorrectionLevel): self
    {
        $this->errorCorrectionLevel = $errorCorrectionLevel;

        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getMargin(): int
    {
        return $this->margin;
    }

    public function setMargin(int $margin): self
    {
        $this->margin = $margin;

        return $this;
    }

    public function getRoundBlockSizeMode(): RoundBlockSizeModeInterface
    {
        return $this->roundBlockSizeMode;
    }

    public function setRoundBlockSizeMode(RoundBlockSizeModeInterface $roundBlockSizeMode): self
    {
        $this->roundBlockSizeMode = $roundBlockSizeMode;

        return $this;
    }

    public function getForegroundColor(): ColorInterface
    {
        return $this->foregroundColor;
    }

    public function setForegroundColor(ColorInterface $foregroundColor): self
    {
        $this->foregroundColor = $foregroundColor;

        return $this;
    }

    public function getBackgroundColor(): ColorInterface
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(ColorInterface $backgroundColor): self
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }
}
