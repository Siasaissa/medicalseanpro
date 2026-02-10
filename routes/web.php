<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DoctorGrid;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\walletController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CallController;
use App\Models\Booking;
use Illuminate\Http\Request; 
use App\Services\ZegoToken; 
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('welcome');
});

//doctor-register
Route::get('/auth/doctor-register', function(){
    return view('auth.doctor-register');
})->name('doctor-register');

//save doctor
Route::post('/auth/doctor-register', [RegisteredUserController::class, 'doctor'])->name('doctor');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//admin routes 
Route::middleware(['auth','verified', 'role:admin'])->group(function (){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/appointment', [AdminController::class, 'appointment'])->name('admin.appointment');
    Route::get('/admin/doctorList', [AdminController::class, 'doctorList'])->name('admin.doctorList');
    Route::get('/admin/patientList', [AdminController::class, 'patientList'])->name('admin.patientList');
    Route::get('/admin/Transaction', [AdminController::class, 'Transaction'])->name('admin.Transaction');
});
// doctor routes
Route::middleware(['auth', 'verified', 'role:doctor'])->group(function () {
    Route::get('/doctor-dashboard', [BookingController::class, 'DoctorDashboard'])->name('doctor-dashboard');
    Route::get('/doctor/mypatients',[DoctorGrid::class, 'MyPatient'])->name('doctor.mypatients');
    Route::get('/doctor/specialities', [DoctorGrid::class, 'speciality'])->name('doctor.specialities');
    Route::post('/specialities/store', [ProfileController::class, 'updateProfile'])->name('specialities.store');
    Route::get('/doctor/profilesettings',[ProfileController::class, 'ProSetting'])->name('doctor.profilesettings');
    Route::put('/doctor/profilesettings', [ProfileController::class, 'updateProfile1'])->name('doctor.profile.update');
    Route::get('/doctor/changePassword', [ProfileController::class, 'password'])->name('doctor.changePassword');
        Route::put('/doctor/update-password', [ProfileController::class, 'updatePassword'])
        ->name('doctor.updatePassword');

    Route::get('/doctor/appointment', [BookingController::class, 'doctorBookings'])->middleware('auth')->name('doctor.appointment');
    Route::get('/doctor/chat', [ChatController::class, 'indexDoctor'])->middleware('auth')->name('doctor.chat');
    Route::post('/doctor/chat/send', [ChatController::class, 'store'])->middleware('auth')->name('chat.store');

    // Doctor call routes
    Route::get('/doctor/video/{booking}', [CallController::class, 'videoDoctor'])->name('doctor.video');
    Route::get('/doctor/voice/{booking}', [CallController::class, 'voiceDoctor'])->name('doctor.voice');
});

// patient routes
Route::middleware(['auth', 'verified', 'role:patient'])->group(function () {
    Route::get('/dashboard', [BookingController::class, 'PatientDashboard'])->name('dashboard');
    Route::get('/patient/favourites', [BookingController::class, 'favourites'])->name('patient.favourites');
    Route::get('/patient/wallet', [walletController::class, 'transaction'])->name('patient.wallet');
    
    Route::get('/patient/vitals', fn () => view('patient.vitals'))->name('patient.vitals');
    Route::get('/patient/settings', fn () => view('patient.settings'))->name('patient.settings');
    Route::get('/patient/doctor-grid', [DoctorGrid::class, 'grid'])->name('patient.doctor-grid');
    Route::get('/patient/booking/{doctor}', [DoctorGrid::class, 'show'])->name('patient.booking');

    Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/patient/booking/{doctor}', [BookingController::class, 'store'])->name('patient.booking.store');
    Route::get('/booking/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('booking.confirmation');

    Route::get('/patient/appointment', [BookingController::class, 'patientBookings'])->name('patient.appointment');

    // ✅ Patient call routes
    Route::get('/patient/video/{booking}', [CallController::class, 'video'])->name('patient.video');
    Route::get('/patient/voice/{booking}', [CallController::class, 'voice'])->name('patient.voice');

    Route::get('/patient/chat', [ChatController::class, 'index'])->middleware('auth')->name('chat.index');
    Route::post('/patient/chat/send', [ChatController::class, 'store'])->middleware('auth')->name('chat.store1');
});

Route::post('/call/signal/{booking}', [CallController::class, 'signal'])->middleware('auth')->name('call.signal');

// ✅ CORRECTED: Changed route path to /api/zego-token and using ZegoToken service
// Add this to your web.php (replace the existing /api/zego-token route)

Route::middleware('auth')->get('/api/zego-token', function (Request $request) {
    $appId = (int) env('ZEGO_APP_ID');
    $serverSecret = env('ZEGO_SERVER_SECRET');

    $bookingId = $request->query('booking_id');
    
    if (!$bookingId) {
        return response()->json(['error' => 'booking_id is required'], 400);
    }

    $userId = (string) $request->user()->id;
    
    // Generate Token04 format (required for UIKit Prebuilt)
    $kitToken = ZegoToken::generateToken04(
        $appId,
        $userId,
        $serverSecret,
        7200,  // 2 hours validity
        ''     // optional payload
    );

    \Log::info('Generated Zego token', [
        'appId' => $appId,
        'userId' => $userId,
        'bookingId' => $bookingId,
        'tokenLength' => strlen($kitToken)
    ]);

    return response()->json([
        'appId' => $appId,
        'kitToken' => $kitToken,
        'userId' => $userId,
        'userName' => $request->user()->name
    ]);
});

Route::middleware(['auth'])->get('/booking/{booking}/call', function (Booking $booking) {
    return view('booking.call', compact('booking'));
});

Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
Route::get('/pharmacy/product', [PharmacyController::class, 'pharmacy'])->name('pharmacy.product');
Route::get('/admin/pharmacy', [PharmacyController::class, 'product'])->name('admin.pharmacy');
Route::get('/admin/AddProduct', [PharmacyController::class, 'AddProduct'])->name('admin.addproduct');
Route::post('/admin/AddProduct/store', [PharmacyController::class, 'store'])->name('products.store');
Route::get('/pharmacy/cart', [PharmacyController::class, 'view'])->name('pharmacy.cart');
Route::post('/cart/add', [PharmacyController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [PharmacyController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [PharmacyController::class, 'update'])->name('cart.update');
Route::get('/pharmacy/checkout', [PharmacyController::class, 'checkout'])->name('pharmacy.checkout');
Route::post('/pharmacy/successfully', [PharmacyController::class, 'payment'])->name('pharmacy.successfully');


Route::post('/doctor/update-availability', [App\Http\Controllers\DoctorGrid::class, 'updateAvailability'])
    ->name('doctor.updateAvailability');

Route::get('/filter/doctors', [DoctorGrid::class, 'filterDoctors'])->name('doctor.filter');

Route::get('/run-storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created successfully!';
});

Route::get('/booking/confirmation/{booking}', [BookingController::class, 'confirmation'])
    ->name('patient.booking.confirmation');
    
Route::get('/token', [BookingController::class, 'showToken']);


require __DIR__.'/auth.php';