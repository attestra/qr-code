<?php

declare(strict_types=1);

namespace Attestra\QrCode\Writer;

use Attestra\QrCode\Label\LabelInterface;
use Attestra\QrCode\Logo\LogoInterface;
use Attestra\QrCode\QrCodeInterface;
use Attestra\QrCode\Writer\Result\ResultInterface;

interface WriterInterface
{
    /** @param array<mixed> $options */
    public function write(QrCodeInterface $qrCode, LogoInterface $logo = null, LabelInterface $label = null, array $options = []): ResultInterface;
}
