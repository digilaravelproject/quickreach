<?php

namespace App\Services;

use App\Models\Category;
use App\Models\QrCode as QrCodeModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\Version;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QROutputInterface;

class QrCodeService
{
    /**
     * Generate bulk QR codes
     */
    public function generateBulkQrCodes(int $categoryId, int $quantity): array
    {
        $category = Category::findOrFail($categoryId);
        $qrCodes = [];

        // Library config to force RAW SVG output
        $options = new QROptions([
            'version'              => Version::AUTO,
            'outputType'           => QROutputInterface::MARKUP_SVG,
            'imageBase64'          => false, // 👈 Sabse important: Base64 band kar diya
            'eccLevel'             => EccLevel::L,
            'addQuietzone'         => true,
            'svgAddXmlDeclaration' => true,
            'svgUseFullAttributes' => true,
        ]);

        $qrcodeGenerator = new QRCode($options);

        for ($i = 0; $i < $quantity; $i++) {
            $qrCodes[] = $this->generateSingleQrCode($category, $qrcodeGenerator);
        }

        return $qrCodes;
    }

    /**
     * Generate single QR code
     */
    public function generateSingleQrCode(Category $category, $generator = null): QrCodeModel
    {
        if (!$generator) {
            $options = new QROptions([
                'version'              => Version::AUTO,
                'outputType'           => QROutputInterface::MARKUP_SVG,
                'imageBase64'          => false, // 👈 Yahan bhi Base64 band
                'eccLevel'             => EccLevel::L,
                'addQuietzone'         => true,
                'svgAddXmlDeclaration' => true,
                'svgUseFullAttributes' => true,
                'connectPaths'         => true,
            ]);
            $generator = new QRCode($options);
        }

        $uniqueCode = 'QR' . strtoupper(Str::random(10));
        // $scanUrl = route('qr.scan', ['code' => $uniqueCode]);
        // QrCodeService.php mein change karein
        $scanUrl = route('public.qr.scan', ['code' => $uniqueCode]);

        // Output buffer saaf karo taki koi extra space na aaye
        if (ob_get_length()) ob_clean();

        // Render QR - ab ye Base64 nahi, pure SVG markup dega
        $qrSvgData = (string)$generator->render($scanUrl);

        // Path setup
        $folderName = $category->slug ?? $category->id;
        $filename = "qr_codes/{$folderName}/{$uniqueCode}.svg";

        // File save karo
        Storage::disk('public')->put($filename, trim($qrSvgData));

        return QrCodeModel::create([
            'qr_code'       => $uniqueCode,
            'category_id'   => $category->id,
            'status'        => 'available',
            'qr_image_path' => $filename,
        ]);
    }

    public function assignQrCodeToUser(QrCodeModel $qrCode, int $userId): QrCodeModel
    {
        $qrCode->update(['user_id' => $userId, 'status' => 'assigned', 'assigned_at' => now()]);
        return $qrCode->fresh();
    }
}
