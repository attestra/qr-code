<?php

declare(strict_types=1);

namespace Attestra\QrCode\Writer;

use Attestra\QrCode\Label\LabelInterface;
use Attestra\QrCode\Logo\LogoInterface;
use Attestra\QrCode\QrCodeInterface;
use Attestra\QrCode\Writer\Result\DebugResult;
use Attestra\QrCode\Writer\Result\ResultInterface;

final class DebugWriter implements WriterInterface, ValidatingWriterInterface
{
    public function write(QrCodeInterface $qrCode, LogoInterface $logo = null, LabelInterface $label = null, array $options = []): ResultInterface
    {
        return new DebugResult($qrCode, $logo, $label, $options);
    }

    public function validateResult(ResultInterface $result, string $expectedData): void
    {
        if (!$result instanceof DebugResult) {
            throw new \Exception('Unable to write logo: instance of DebugResult expected');
        }

        $result->setValidateResult(true);
    }
}
