<?php

declare(strict_types=1);

namespace Attestra\QrCode\Label;

use Attestra\QrCode\Color\ColorInterface;
use Attestra\QrCode\Label\Alignment\LabelAlignmentInterface;
use Attestra\QrCode\Label\Font\FontInterface;
use Attestra\QrCode\Label\Margin\MarginInterface;

interface LabelInterface
{
    public function getText(): string;

    public function getFont(): FontInterface;

    public function getAlignment(): LabelAlignmentInterface;

    public function getMargin(): MarginInterface;

    public function getTextColor(): ColorInterface;
}
