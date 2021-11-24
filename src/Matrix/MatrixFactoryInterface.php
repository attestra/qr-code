<?php

declare(strict_types=1);

namespace Attestra\QrCode\Matrix;

use Attestra\QrCode\QrCodeInterface;

interface MatrixFactoryInterface
{
    public function create(QrCodeInterface $qrCode): MatrixInterface;
}
