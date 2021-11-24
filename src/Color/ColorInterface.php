<?php

declare(strict_types=1);

namespace Attestra\QrCode\Color;

interface ColorInterface
{
    public function getRed(): int;

    public function getGreen(): int;

    public function getBlue(): int;

    public function getAlpha(): int;

    public function getOpacity(): float;

    /** @return array<string, int> */
    public function toArray(): array;
}
