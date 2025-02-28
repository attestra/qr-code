<?php

declare(strict_types=1);

namespace Attestra\QrCode\Writer\Result;

use Attestra\QrCode\Label\LabelInterface;
use Attestra\QrCode\Logo\LogoInterface;
use Attestra\QrCode\QrCodeInterface;

final class DebugResult extends AbstractResult
{
    private QrCodeInterface $qrCode;
    private ?LogoInterface $logo;
    private ?LabelInterface $label;

    /** @var array<mixed> */
    private array $options;

    private bool $validateResult = false;

    /** @param array<mixed> $options */
    public function __construct(QrCodeInterface $qrCode, LogoInterface $logo = null, LabelInterface $label = null, array $options = [])
    {
        $this->qrCode = $qrCode;
        $this->logo = $logo;
        $this->label = $label;
        $this->options = $options;
    }

    public function setValidateResult(bool $validateResult): void
    {
        $this->validateResult = $validateResult;
    }

    public function getString(): string
    {
        $debugLines = [];

        $debugLines[] = 'Data: '.$this->qrCode->getData();
        $debugLines[] = 'Encoding: '.$this->qrCode->getEncoding();
        $debugLines[] = 'Error Correction Level: '.get_class($this->qrCode->getErrorCorrectionLevel());
        $debugLines[] = 'Size: '.$this->qrCode->getSize();
        $debugLines[] = 'Margin: '.$this->qrCode->getMargin();
        $debugLines[] = 'Round block size mode: '.get_class($this->qrCode->getRoundBlockSizeMode());
        $debugLines[] = 'Foreground color: ['.implode(', ', $this->qrCode->getForegroundColor()->toArray()).']';
        $debugLines[] = 'Background color: ['.implode(', ', $this->qrCode->getBackgroundColor()->toArray()).']';

        foreach ($this->options as $key => $value) {
            $debugLines[] = 'Writer option: '.$key.': '.$value;
        }

        if (isset($this->logo)) {
            $debugLines[] = 'Logo path: '.$this->logo->getPath();
            $debugLines[] = 'Logo resize to width: '.$this->logo->getResizeToWidth();
            $debugLines[] = 'Logo resize to height: '.$this->logo->getResizeToHeight();
        }

        if (isset($this->label)) {
            $debugLines[] = 'Label text: '.$this->label->getText();
            $debugLines[] = 'Label font path: '.$this->label->getFont()->getPath();
            $debugLines[] = 'Label font size: '.$this->label->getFont()->getSize();
            $debugLines[] = 'Label alignment: '.get_class($this->label->getAlignment());
            $debugLines[] = 'Label margin: ['.implode(', ', $this->label->getMargin()->toArray()).']';
            $debugLines[] = 'Label text color: ['.implode(', ', $this->label->getTextColor()->toArray()).']';
        }

        $debugLines[] = 'Validate result: '.($this->validateResult ? 'true' : 'false');

        return implode("\n", $debugLines);
    }

    public function getMimeType(): string
    {
        return 'text/plain';
    }
}
