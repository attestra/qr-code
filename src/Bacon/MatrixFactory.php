<?php

declare(strict_types=1);

namespace Attestra\QrCode\Bacon;

use BaconQrCode\Encoder\Encoder;
use Attestra\QrCode\Matrix\Matrix;
use Attestra\QrCode\Matrix\MatrixFactoryInterface;
use Attestra\QrCode\Matrix\MatrixInterface;
use Attestra\QrCode\QrCodeInterface;

final class MatrixFactory implements MatrixFactoryInterface
{
    public function create(QrCodeInterface $qrCode): MatrixInterface
    {
        $baconErrorCorrectionLevel = ErrorCorrectionLevelConverter::convertToBaconErrorCorrectionLevel($qrCode->getErrorCorrectionLevel());
        $baconMatrix = Encoder::encode($qrCode->getData(), $baconErrorCorrectionLevel, strval($qrCode->getEncoding()))->getMatrix();

        $blockValues = [];
        $columnCount = $baconMatrix->getWidth();
        $rowCount = $baconMatrix->getHeight();
        for ($rowIndex = 0; $rowIndex < $rowCount; ++$rowIndex) {
            $blockValues[$rowIndex] = [];
            for ($columnIndex = 0; $columnIndex < $columnCount; ++$columnIndex) {
                $blockValues[$rowIndex][$columnIndex] = $baconMatrix->get($columnIndex, $rowIndex);
            }
        }

        return new Matrix($blockValues, $qrCode->getSize(), $qrCode->getMargin(), $qrCode->getRoundBlockSizeMode());
    }
}
