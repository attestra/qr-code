<?php

declare(strict_types=1);

namespace Attestra\QrCode\Builder;

use Attestra\QrCode\Color\ColorInterface;
use Attestra\QrCode\Encoding\EncodingInterface;
use Attestra\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelInterface;
use Attestra\QrCode\Label\Alignment\LabelAlignmentInterface;
use Attestra\QrCode\Label\Font\FontInterface;
use Attestra\QrCode\Label\Label;
use Attestra\QrCode\Label\LabelInterface;
use Attestra\QrCode\Label\Margin\MarginInterface;
use Attestra\QrCode\Logo\Logo;
use Attestra\QrCode\Logo\LogoInterface;
use Attestra\QrCode\QrCode;
use Attestra\QrCode\RoundBlockSizeMode\RoundBlockSizeModeInterface;
use Attestra\QrCode\Writer\PngWriter;
use Attestra\QrCode\Writer\Result\ResultInterface;
use Attestra\QrCode\Writer\ValidatingWriterInterface;
use Attestra\QrCode\Writer\WriterInterface;

class Builder implements BuilderInterface
{
    /**
     * @var array<mixed>{
     *     data: string,
     *     writer: WriterInterface,
     *     writerOptions: array,
     *     qrCodeClass: class-string,
     *     logoClass: class-string,
     *     labelClass: class-string,
     *     validateResult: bool,
     *     size?: int,
     *     encoding?: EncodingInterface,
     *     errorCorrectionLevel?: ErrorCorrectionLevelInterface,
     *     roundBlockSizeMode?: RoundBlockSizeModeInterface,
     *     margin?: int,
     *     backgroundColor?: ColorInterface,
     *     foregroundColor?: ColorInterface,
     *     labelText?: string,
     *     labelFont?: FontInterface,
     *     labelAlignment?: LabelAlignmentInterface,
     *     labelMargin?: MarginInterface,
     *     labelTextColor?: ColorInterface,
     *     logoPath?: string,
     *     logoResizeToWidth?: int,
     *     logoResizeToHeight?: int,
     *     logoPunchoutBackground?: bool
     * }
     */
    private array $options;

    public function __construct()
    {
        $this->options = [
            'data' => '',
            'writer' => new PngWriter(),
            'writerOptions' => [],
            'qrCodeClass' => QrCode::class,
            'logoClass' => Logo::class,
            'labelClass' => Label::class,
            'validateResult' => false,
        ];
    }

    public static function create(): BuilderInterface
    {
        return new self();
    }

    public function writer(WriterInterface $writer): BuilderInterface
    {
        $this->options['writer'] = $writer;

        return $this;
    }

    /** @param array<mixed> $writerOptions */
    public function writerOptions(array $writerOptions): BuilderInterface
    {
        $this->options['writerOptions'] = $writerOptions;

        return $this;
    }

    public function data(string $data): BuilderInterface
    {
        $this->options['data'] = $data;

        return $this;
    }

    public function encoding(EncodingInterface $encoding): BuilderInterface
    {
        $this->options['encoding'] = $encoding;

        return $this;
    }

    public function errorCorrectionLevel(ErrorCorrectionLevelInterface $errorCorrectionLevel): BuilderInterface
    {
        $this->options['errorCorrectionLevel'] = $errorCorrectionLevel;

        return $this;
    }

    public function size(int $size): BuilderInterface
    {
        $this->options['size'] = $size;

        return $this;
    }

    public function margin(int $margin): BuilderInterface
    {
        $this->options['margin'] = $margin;

        return $this;
    }

    public function roundBlockSizeMode(RoundBlockSizeModeInterface $roundBlockSizeMode): BuilderInterface
    {
        $this->options['roundBlockSizeMode'] = $roundBlockSizeMode;

        return $this;
    }

    public function foregroundColor(ColorInterface $foregroundColor): BuilderInterface
    {
        $this->options['foregroundColor'] = $foregroundColor;

        return $this;
    }

    public function backgroundColor(ColorInterface $backgroundColor): BuilderInterface
    {
        $this->options['backgroundColor'] = $backgroundColor;

        return $this;
    }

    public function logoPath(string $logoPath): BuilderInterface
    {
        $this->options['logoPath'] = $logoPath;

        return $this;
    }

    public function logoResizeToWidth(int $logoResizeToWidth): BuilderInterface
    {
        $this->options['logoResizeToWidth'] = $logoResizeToWidth;

        return $this;
    }

    public function logoResizeToHeight(int $logoResizeToHeight): BuilderInterface
    {
        $this->options['logoResizeToHeight'] = $logoResizeToHeight;

        return $this;
    }

    public function logoPunchoutBackground(bool $logoPunchoutBackground): BuilderInterface
    {
        $this->options['logoPunchoutBackground'] = $logoPunchoutBackground;

        return $this;
    }

    public function labelText(string $labelText): BuilderInterface
    {
        $this->options['labelText'] = $labelText;

        return $this;
    }

    public function labelFont(FontInterface $labelFont): BuilderInterface
    {
        $this->options['labelFont'] = $labelFont;

        return $this;
    }

    public function labelAlignment(LabelAlignmentInterface $labelAlignment): BuilderInterface
    {
        $this->options['labelAlignment'] = $labelAlignment;

        return $this;
    }

    public function labelMargin(MarginInterface $labelMargin): BuilderInterface
    {
        $this->options['labelMargin'] = $labelMargin;

        return $this;
    }

    public function labelTextColor(ColorInterface $labelTextColor): BuilderInterface
    {
        $this->options['labelTextColor'] = $labelTextColor;

        return $this;
    }

    public function validateResult(bool $validateResult): BuilderInterface
    {
        $this->options['validateResult'] = $validateResult;

        return $this;
    }

    public function build(): ResultInterface
    {
        $writer = $this->options['writer'];

        if ($this->options['validateResult'] && !$writer instanceof ValidatingWriterInterface) {
            throw new \Exception('Unable to validate result with '.get_class($writer));
        }

        /** @var QrCode $qrCode */
        $qrCode = $this->buildObject($this->options['qrCodeClass']);

        /** @var LogoInterface|null $logo */
        $logo = $this->buildObject($this->options['logoClass'], 'logo');

        /** @var LabelInterface|null $label */
        $label = $this->buildObject($this->options['labelClass'], 'label');

        $result = $writer->write($qrCode, $logo, $label, $this->options['writerOptions']);

        if ($this->options['validateResult'] && $writer instanceof ValidatingWriterInterface) {
            $writer->validateResult($result, $qrCode->getData());
        }

        return $result;
    }

    /**
     * @param class-string $class
     *
     * @return mixed
     */
    private function buildObject(string $class, string $optionsPrefix = null)
    {
        /** @var \ReflectionClass<object> $reflectionClass */
        $reflectionClass = new \ReflectionClass($class);

        $arguments = [];
        $hasBuilderOptions = false;
        $missingRequiredArguments = [];
        /** @var \ReflectionMethod $constructor */
        $constructor = $reflectionClass->getConstructor();
        $constructorParameters = $constructor->getParameters();
        foreach ($constructorParameters as $parameter) {
            $optionName = null === $optionsPrefix ? $parameter->getName() : $optionsPrefix.ucfirst($parameter->getName());
            if (isset($this->options[$optionName])) {
                $hasBuilderOptions = true;
                $arguments[] = $this->options[$optionName];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $arguments[] = $parameter->getDefaultValue();
            } else {
                $missingRequiredArguments[] = $optionName;
            }
        }

        if (!$hasBuilderOptions) {
            return null;
        }

        if (count($missingRequiredArguments) > 0) {
            throw new \Exception(sprintf('Missing required arguments: %s', implode(', ', $missingRequiredArguments)));
        }

        return $reflectionClass->newInstanceArgs($arguments);
    }
}
