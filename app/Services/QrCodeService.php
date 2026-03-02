<?php

namespace App\Services;

use App\Models\Category;
use App\Models\QrCode as QrCodeModel;
use App\Models\QrBatch;
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
     * Generate bulk QR codes with Batch tracking
     */
    public function generateBulkQrCodes(int $categoryId, int $quantity): array
    {
        $category = Category::findOrFail($categoryId);

        // 1. Create a new Batch record
        $batch = QrBatch::create([
            'batch_code' => QrBatch::generateBatchCode($category->name, $quantity),
            'category_id' => $category->id,
            'quantity' => $quantity
        ]);

        $qrCodes = [];

        for ($i = 0; $i < $quantity; $i++) {
            // ✅ Pass the batch ID to the single generator
            $qrCodes[] = $this->generateSingleQrCode($category, $batch->id);
        }

        return $qrCodes;
    }

    /**
     * Generate single QR code
     */
    public function generateSingleQrCode(Category $category, $batchId = null): QrCodeModel
    {
        // ✅ Har call pe fresh options aur fresh generator instance
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

        $freshGenerator = new QRCode($options);

        // ✅ Unique code DB check ke saath
        do {
            $uniqueCode = 'QR' . strtoupper(Str::random(10));
        } while (QrCodeModel::where('qr_code', $uniqueCode)->exists());

        $scanUrl = route('public.qr.scan', ['code' => $uniqueCode]);

        if (ob_get_length()) ob_clean();

        // ✅ Fresh generator pe render karo
        $qrSvgData = (string)$freshGenerator->render($scanUrl);

        $folderName = $category->slug ?? $category->id;
        $filename = "qr_codes/{$folderName}/{$uniqueCode}.svg";

        Storage::disk('public')->put($filename, trim($qrSvgData));

        return QrCodeModel::create([
            'qr_code'       => $uniqueCode,
            'category_id'   => $category->id,
            'qr_batch_id'   => $batchId, // ✅ Assigned to the new batch
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
