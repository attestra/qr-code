<?php

declare(strict_types=1);

namespace Attestra\QrCode\Builder;

use Attestra\QrCode\Color\ColorInterface;
use Attestra\QrCode\Encoding\EncodingInterface;
use Attestra\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelInterface;
use Attestra\QrCode\Label\Alignment\LabelAlignmentInterface;
use Attestra\QrCode\Label\Font\FontInterface;
use Attestra\QrCode\Label\Margin\MarginInterface;
use Attestra\QrCode\RoundBlockSizeMode\RoundBlockSizeModeInterface;
use Attestra\QrCode\Writer\Result\ResultInterface;
use Attestra\QrCode\Writer\WriterInterface;

interface BuilderInterface
{
    public static function create(): BuilderInterface;

    public function writer(WriterInterface $writer): BuilderInterface;

    /** @param array<mixed> $writerOptions */
    public function writerOptions(array $writerOptions): BuilderInterface;

    public function data(string $data): BuilderInterface;

    public function encoding(EncodingInterface $encoding): BuilderInterface;

    public function errorCorrectionLevel(ErrorCorrectionLevelInterface $errorCorrectionLevel): BuilderInterface;

    public function size(int $size): BuilderInterface;

    public function margin(int $margin): BuilderInterface;

    public function roundBlockSizeMode(RoundBlockSizeModeInterface $roundBlockSizeMode): BuilderInterface;

    public function foregroundColor(ColorInterface $foregroundColor): BuilderInterface;

    public function backgroundColor(ColorInterface $backgroundColor): BuilderInterface;

    public function logoPath(string $logoPath): BuilderInterface;

    public function logoResizeToWidth(int $logoResizeToWidth): BuilderInterface;

    public function logoResizeToHeight(int $logoResizeToHeight): BuilderInterface;

    public function logoPunchoutBackground(bool $logoPunchoutBackground): BuilderInterface;

    public function labelText(string $labelText): BuilderInterface;

    public function labelFont(FontInterface $labelFont): BuilderInterface;

    public function labelAlignment(LabelAlignmentInterface $labelAlignment): BuilderInterface;

    public function labelMargin(MarginInterface $labelMargin): BuilderInterface;

    public function labelTextColor(ColorInterface $labelTextColor): BuilderInterface;

    public function validateResult(bool $validateResult): BuilderInterface;

    public function build(): ResultInterface;
}
