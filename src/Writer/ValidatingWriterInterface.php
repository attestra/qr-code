<?php

declare(strict_types=1);

namespace Attestra\QrCode\Writer;

use Attestra\QrCode\Writer\Result\ResultInterface;

interface ValidatingWriterInterface
{
    public function validateResult(ResultInterface $result, string $expectedData): void;
}
