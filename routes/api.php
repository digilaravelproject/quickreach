<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrScanController;

/*
|--------------------------------------------------------------------------
| API Routes for QR Scanning
|--------------------------------------------------------------------------
|
| These routes handle AJAX requests from the contact owner page
|
*/

// QR Code Scan Actions (No authentication required - public access)
Route::prefix('qr')->group(function () {

    // Get WhatsApp link
    Route::get('/{qrCode}/whatsapp', [QrScanController::class, 'initiateWhatsApp'])
        ->name('api.qr.whatsapp');

    // Initiate call to owner
    Route::post('/{qrCode}/call', [QrScanController::class, 'initiateCall'])
        ->name('api.qr.call');

    // Get emergency contacts
    Route::get('/{qrCode}/emergency', [QrScanController::class, 'emergencyContact'])
        ->name('api.qr.emergency');

    // Initiate emergency call
    Route::post('/{qrCode}/emergency-call', [QrScanController::class, 'initiateEmergencyCall'])
        ->name('api.qr.emergency-call');
});
