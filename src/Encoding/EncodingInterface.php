<?php

declare(strict_types=1);

namespace Attestra\QrCode\Encoding;

interface EncodingInterface
{
    public function __toString(): string;
}
