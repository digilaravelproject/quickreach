<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QrCodeController as AdminQrCodeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QrRegistrationController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ContactControllerAdmin;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Admin\UserNewController;
use App\Http\Controllers\Admin\PrivacyPolicyController;


use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QrScanController;
use App\Http\Controllers\Api\PaymentWebhookController;
use App\Http\Controllers\Api\TwilioWebhookController;
use chillerlan\QRCode\QRCode;

/*
|--------------------------------------------------------------------------
| 1. Landing Page - Redirect to Products (Public)
|--------------------------------------------------------------------------
*/

Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

Route::get('/', function () {
    return redirect()->route('user.products');
})->name('home');

/*
|--------------------------------------------------------------------------
| 2. Test Route
|--------------------------------------------------------------------------
*/
Route::get('/test-qr', function () {
    return (new QRCode)->render('https://qwickreach.com');
});

/*
|--------------------------------------------------------------------------
| 3. Profile Routes (Authenticated Users)
|--------------------------------------------------------------------------
*/
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware('auth')->prefix('user')->name('user.')->group(
    function () {
        Route::get('/my-orders-new', [UserController::class, 'index'])->name('new.orders.index');
        Route::get('/my-orders/{id}', [UserController::class, 'show'])->name('orders.show');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


        Route::post('/create-order',        [UserController::class, 'createOrder'])->name('create.order');

        // Verify payment signature after Razorpay callback
        Route::post('/verify-payment',      [UserController::class, 'verifyPayment'])->name('verify.payment');

        // Order success page
        Route::get('/order-success',        [UserController::class, 'orderSuccess'])->name('order.success');

        // ── User Dashboard ───────────────────────────────────────────
        Route::get('/my-qrs',               [UserController::class, 'myQrs'])->name('my-qrs');
        Route::get('/my-orders',            [UserController::class, 'myOrders'])->name('my-orders');
        Route::get('/profile',              [UserController::class, 'profile'])->name('profile');
    }
);

/*
|--------------------------------------------------------------------------
| 4. QR Scanner Routes (Public - No Auth Required)
|--------------------------------------------------------------------------
*/
Route::prefix('scan')->name('qr.')->group(function () {
    Route::get('/', [QrScanController::class, 'showScanner'])->name('scanner');
    Route::post('/process', [QrScanController::class, 'processScan'])->name('process');

    Route::get('/{code}', [QrScanController::class, 'scan'])->name('scan');
    Route::post('/{qrCode}/call', [QrScanController::class, 'initiateCall'])->name('call');
    Route::get('/{qrCode}/whatsapp', [QrScanController::class, 'initiateWhatsApp'])->name('whatsapp');
    Route::get('/{qrCode}/emergency', [QrScanController::class, 'emergencyContact'])->name('emergency');
    Route::post('/{qrCode}/emergency-call', [QrScanController::class, 'initiateEmergencyCall'])->name('emergency-call');
});

/*
|--------------------------------------------------------------------------
| 5. User Routes (Public + Auth)
|--------------------------------------------------------------------------
*/
// Route::prefix('user')->name('user.')->group(function () {
//     // Public routes - no authentication required
//     Route::get('/products', [UserController::class, 'products'])->name('products');
//     Route::get('/category/{category}', [UserController::class, 'showCategory'])->name('category');


//     // Authenticated routes - login required

//     Route::post('/checkout', [UserController::class, 'cartCheckout'])->name('checkout');
//     Route::post('/payment/verify', [UserController::class, 'verifyPayment'])->name('payment.verify');
//     Route::get('/register-qr/{qrCode}', [UserController::class, 'showRegistrationForm'])->name('register-qr');
//     Route::post('/register-qr/{qrCode}', [UserController::class, 'storeRegistration'])->name('register-qr.store');
//     Route::get('/my-qrs', [UserController::class, 'myQrs'])->name('my-qrs');
//     Route::get('/qr/{qrCode}/download', [UserController::class, 'downloadQrImage'])->name('qr.download');
// });

// Route::prefix('user')->name('user.')->group(function () {

//     // --- Public Routes ---
//     Route::get('/products', [UserController::class, 'products'])->name('products');
//     Route::get('/category/{category}', [UserController::class, 'showCategory'])->name('category');



//     // Cart & Checkout
//     Route::get('/checkout', [UserController::class, 'cartCheckout'])->name('checkout');
//     Route::post('/order/create', [UserController::class, 'createOrder'])->name('create.order'); // Added (Missing in your code)

//     // Payment Processing
//     Route::post('/payment/verify', [UserController::class, 'verifyPayment'])->name('verify.payment');
//     Route::get('/order/success', [UserController::class, 'orderSuccess'])->name('order.success'); // Added

//     // QR Registration
//     Route::get('/register-qr/{qrCode}', [UserController::class, 'showRegistrationForm'])->name('register-qr');
//     Route::post('/register-qr/{qrCode}', [UserController::class, 'storeRegistration'])->name('register-qr.store');

//     // Dashboard / User Account
//     Route::get('/my-qrs', [UserController::class, 'myQrs'])->name('my-qrs');
//     Route::get('/my-orders', [UserController::class, 'myOrders'])->name('my-orders'); // Added
//     Route::get('/profile', [UserController::class, 'profile'])->name('profile'); // Added

//     // Utilities
//     Route::get('/qr/{qrCode}/download', [UserController::class, 'downloadQrImage'])->name('qr.download');
// });

Route::prefix('user')->name('user.')->group(function () {

    // --- Public Store Routes ---
    Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy.index');
    Route::get('/category/{category}', [UserController::class, 'showCategory'])->name('category');
    Route::get('/checkout', [UserController::class, 'cartCheckout'])->name('checkout');
    Route::get('/about-us', [AboutController::class, 'index'])->name('about.index');
    // User routes for Contact Page
    Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

    Route::get('/products', [UserController::class, 'products'])->name('products');

    Route::post('/user/register', [QrScanController::class, 'storeRegistration'])->name('store-registration');


    // Route::post('/order/create', [UserController::class, 'createOrder'])->name('create.order');
    // Route::post('/payment/verify', [UserController::class, 'verifyPayment'])->name('verify.payment');
    // Route::get('/order/success', [UserController::class, 'orderSuccess'])->name('order.success');

    // --- QR Registration (For Owners) ---
    Route::get('/register-qr/{qrCode}', [UserController::class, 'showRegistrationForm'])->name('register-qr');
    Route::post('/register-qr/{qrCode}', [UserController::class, 'storeRegistration'])->name('register-qr.store');

    // --- Dashboard ---
    // Route::get('/my-qrs', [UserController::class, 'myQrs'])->name('my-qrs');
    // Route::get('/my-orders', [UserController::class, 'myOrders'])->name('my-orders');
    // Route::get('/profile', [UserController::class, 'profile'])->name('profile');
});

// --- Public Scanning Route (Anyone can access) ---
Route::get('/scan/{code}', [QrScanController::class, 'scan'])->name('public.qr.scan');

/*
|--------------------------------------------------------------------------
| 6. Admin Routes (Admin Middleware - Only Admins)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/contacts', [ContactControllerAdmin::class, 'index'])->name('contacts.index');
    Route::get('/contacts/toggle/{id}', [ContactControllerAdmin::class, 'toggleRead'])->name('contacts.toggle');
    Route::delete('/contacts/{id}', [ContactControllerAdmin::class, 'destroy'])->name('contacts.destroy');

    Route::get('/privacy-policy/edit', [PrivacyPolicyController::class, 'edit'])->name('privacy.edit');
    Route::post('/privacy-policy/update', [PrivacyPolicyController::class, 'update'])->name('privacy.update');

    Route::get('/admin/about', [AboutController::class, 'edit'])->name('about.edit');
    Route::post('/admin/about', [AboutController::class, 'update'])->name('about.update');
    // Announcements
    Route::get('announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('announcements/toggle/{id}', [AnnouncementController::class, 'toggleStatus'])->name('announcements.toggle');
    Route::delete('announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    // Slider Resource Routes
    Route::resource('sliders', SliderController::class);
    Route::post('sliders/{id}/toggle-status', [SliderController::class, 'toggleStatus'])->name('sliders.toggle');
    Route::post('sliders/update/{id}', [SliderController::class, 'update'])->name('sliders.custom_update');

    Route::resource('registrations', QrRegistrationController::class);
    Route::get('/users', [UserNewController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserNewController::class, 'show'])->name('users.show');

    Route::get('/qr/download/{id}', [UserNewController::class, 'downloadCard'])->name('qr.download');
    Route::get('/qr/generate-card/{id}', [UserNewController::class, 'generateCard'])->name('qr.generateCard');

    // Categories
    Route::resource('categories', CategoryController::class);
    Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    // QR Inventory
    Route::resource('qr-codes', AdminQrCodeController::class);
    Route::post('qr-codes/bulk-delete', [AdminQrCodeController::class, 'bulkDestroy'])->name('qr-codes.bulk-destroy');
    Route::post('qr-codes/{qrCode}/update-status', [AdminQrCodeController::class, 'updateStatus'])->name('qr-codes.update-status');
    Route::post('qr-codes/download-bulk', [AdminQrCodeController::class, 'downloadBulk'])->name('qr-codes.download-bulk');
    Route::get('qr-codes/export/csv', [AdminQrCodeController::class, 'exportCsv'])->name('qr-codes.export-csv');

    // Payments
    Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/create', [AdminPaymentController::class, 'create'])->name('payments.create');
    Route::post('payments/store', [AdminPaymentController::class, 'store'])->name('payments.store');
    Route::get('payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
    Route::post('payments/{payment}/refund', [AdminPaymentController::class, 'refund'])->name('payments.refund');

    Route::get('analytics', [DashboardController::class, 'analytics'])->name('analytics');
});

/*
|--------------------------------------------------------------------------
| 7. API Webhooks (Public)
|--------------------------------------------------------------------------
*/
Route::prefix('api')->name('api.')->group(function () {
    Route::post('/webhook/razorpay', [PaymentWebhookController::class, 'razorpay'])->name('webhook.razorpay');
    Route::post('/webhook/twilio', [TwilioWebhookController::class, 'callback'])->name('twilio.callback');
});

/*
|--------------------------------------------------------------------------
| 8. Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
