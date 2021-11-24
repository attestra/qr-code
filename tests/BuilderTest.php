<?php

declare(strict_types=1);

namespace Attestra\QrCode\Tests;

use Attestra\QrCode\Builder\Builder;
use Attestra\QrCode\Encoding\Encoding;
use Attestra\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Attestra\QrCode\Label\Alignment\LabelAlignmentCenter;
use Attestra\QrCode\Label\Font\NotoSans;
use Attestra\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Attestra\QrCode\Writer\PngWriter;
use Attestra\QrCode\Writer\Result\PngResult;
use PHPUnit\Framework\TestCase;

final class BuilderTest extends TestCase
{
    /**
     * @testdox Write advanced example via builder
     */
    public function testBuilder(): void
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data('Custom QR code contents')
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->logoPath(__DIR__.'/assets/symfony.png')
            ->labelText('This is the label')
            ->labelFont(new NotoSans(20))
            ->labelAlignment(new LabelAlignmentCenter())
            ->build()
        ;

        $this->assertInstanceOf(PngResult::class, $result);
        $this->assertEquals('image/png', $result->getMimeType());
    }
}
