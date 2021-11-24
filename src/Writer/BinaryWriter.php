<?php

declare(strict_types=1);

namespace Attestra\QrCode\Writer;

use Attestra\QrCode\Bacon\MatrixFactory;
use Attestra\QrCode\Label\LabelInterface;
use Attestra\QrCode\Logo\LogoInterface;
use Attestra\QrCode\QrCodeInterface;
use Attestra\QrCode\Writer\Result\BinaryResult;
use Attestra\QrCode\Writer\Result\ResultInterface;

final class BinaryWriter implements WriterInterface
{
    public function write(QrCodeInterface $qrCode, LogoInterface $logo = null, LabelInterface $label = null, array $options = []): ResultInterface
    {
        $matrixFactory = new MatrixFactory();
        $matrix = $matrixFactory->create($qrCode);

        return new BinaryResult($matrix);
    }
}
