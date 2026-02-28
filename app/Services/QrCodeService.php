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

        for ($i = 0; $i < $quantity; $i++) {
            // ✅ FIX: Generator har iteration mein fresh banao - shared instance state cache karta hai
            $qrCodes[] = $this->generateSingleQrCode($category);
        }

        return $qrCodes;
    }

    /**
     * Generate single QR code
     */
    public function generateSingleQrCode(Category $category, $generator = null): QrCodeModel
    {
        // ✅ FIX: Har call pe fresh options aur fresh generator instance
        $options = new QROptions([
            'version'              => Version::AUTO,
            'outputType'           => QROutputInterface::MARKUP_SVG,
            'imageBase64'          => false,
            'eccLevel'             => EccLevel::L,
            'addQuietzone'         => true,
            'svgAddXmlDeclaration' => true,
            'svgUseFullAttributes' => true,
            'connectPaths'         => true,
        ]);

        // ✅ FIX: Passed generator ignore karo, har baar naya banao
        $freshGenerator = new QRCode($options);

        // ✅ FIX: Unique code DB check ke saath
        do {
            $uniqueCode = 'QR' . strtoupper(Str::random(10));
        } while (QrCodeModel::where('qr_code', $uniqueCode)->exists());

        $scanUrl = route('public.qr.scan', ['code' => $uniqueCode]);

        if (ob_get_length()) ob_clean();

        // ✅ FIX: Fresh generator pe render karo
        $qrSvgData = (string)$freshGenerator->render($scanUrl);

        $folderName = $category->slug ?? $category->id;
        $filename = "qr_codes/{$folderName}/{$uniqueCode}.svg";

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
