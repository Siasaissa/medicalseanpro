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
use App\Http\Controllers\PatientVitalController;
use Carbon\Carbon;
use App\Http\Controllers\Auth\GoogleController;

// patient
Route::get('auth/google/patient', [GoogleController::class, 'redirectToGooglePatient'])->name('google.patient');
Route::get('auth/google/callback/patient', [GoogleController::class, 'handleGoogleCallbackPatient'])->name('google.callback.patient');
// doctor
Route::get('auth/google/doctor', [GoogleController::class, 'redirectToGoogleDoctor'])->name('google.doctor');
Route::get('auth/google/callback/doctor', [GoogleController::class, 'handleGoogleCallbackDoctor'])->name('google.callback.doctor');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::view('/about-us', 'about-us')->name('about.us');
Route::view('/blog-grid', 'blog-grid')->name('blog.grid');

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
    Route::get('/admin/Transaction', [AdminController::class, 'transaction'])->name('admin.Transaction');
    Route::post('/admin/users/{user}/status', [AdminController::class, 'updateUserStatus'])->name('admin.users.status');
    Route::post('/admin/bookings/{booking}/status', [AdminController::class, 'updateBookingStatus'])->name('admin.bookings.status');
    Route::post('/admin/transactions/{order}/status', [AdminController::class, 'updateTransactionStatus'])->name('admin.transactions.status');
    Route::delete('/admin/transactions/{order}', [AdminController::class, 'destroyTransaction'])->name('admin.transactions.destroy');
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
    Route::put('/doctor/update-password', [ProfileController::class, 'updatePassword'])->name('doctor.updatePassword');

    Route::get('/doctor/appointment', [BookingController::class, 'doctorBookings'])->middleware('auth')->name('doctor.appointment');
    Route::get('/doctor/appointment/booking/{booking}', [BookingController::class, 'doctorBookingRedirect'])->name('doctor.appointment.booking');
    
    // Doctor chat routes
    Route::get('/doctor/chat', [ChatController::class, 'indexDoctor'])->middleware('auth')->name('doctor.chat');
    Route::post('/doctor/chat/send', [ChatController::class, 'store'])->middleware('auth')->name('chat.store');
    
    // Doctor chat API routes for polling
    Route::get('/doctor/chat/messages/new', [ChatController::class, 'getNewMessages'])->middleware('auth')->name('doctor.chat.messages.new');
    Route::post('/doctor/chat/mark-read', [ChatController::class, 'markAsRead'])->middleware('auth')->name('doctor.chat.mark.read');
    Route::post('/doctor/chat/mark-message-read/{messageId}', [ChatController::class, 'markMessageAsRead'])->middleware('auth')->name('doctor.chat.mark.message.read');
    Route::get('/doctor/chat/unread-counts', [ChatController::class, 'getUnreadCounts'])->middleware('auth')->name('doctor.chat.unread.counts');
    Route::get('/doctor/chat/messages/{bookingId}/status', [ChatController::class, 'getMessagesWithStatus'])->middleware('auth')->name('doctor.chat.messages.status');
    
    // Add this route for marking all messages in a booking as read
    Route::post('/doctor/chat/mark-booking-read/{bookingId}', [ChatController::class, 'markBookingAsRead'])->middleware('auth')->name('doctor.chat.mark.booking.read');

    // Doctor call routes
    Route::get('/doctor/video/{booking}', [CallController::class, 'videoDoctor'])->name('doctor.video');
    Route::get('/doctor/voice/{booking}', [CallController::class, 'voiceDoctor'])->name('doctor.voice');
    Route::get('/doctor/home/{booking}', [CallController::class, 'homeDoctor'])->name('doctor.home');
});

// patient routes
Route::middleware(['auth', 'verified', 'role:patient'])->group(function () {
    Route::get('/dashboard', [BookingController::class, 'PatientDashboard'])->name('dashboard');
    Route::get('/patient/favourites', [BookingController::class, 'favourites'])->name('patient.favourites');
    Route::get('/patient/wallet', [walletController::class, 'transaction'])->name('patient.wallet');
    
    Route::get('/patient/vitals', [PatientVitalController::class, 'index'])->name('patient.vitals');
    Route::post('/patient/vitals', [PatientVitalController::class, 'store'])->name('patient.vitals.store');
    Route::delete('/patient/vitals/{vital}', [PatientVitalController::class, 'destroy'])->name('patient.vitals.destroy');
    Route::get('/patient/settings', fn () => view('patient.settings'))->name('patient.settings');
    Route::get('/patient/doctor-grid', [DoctorGrid::class, 'grid'])->name('patient.doctor-grid');

    Route::get('/doctors/list', [DoctorGrid::class, 'list'])->name('doctor.list');
    Route::get('/doctors/map', [DoctorGrid::class, 'map'])->name('doctor.map');

    Route::get('/patient/booking/{doctor}', [DoctorGrid::class, 'show'])->name('patient.booking');

    Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/patient/booking/{doctor}', [BookingController::class, 'store'])->name('patient.booking.store');
    Route::get('/booking/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('booking.confirmation');

    Route::get('/patient/appointment', [BookingController::class, 'patientBookings'])->name('patient.appointment');

    // Patient call routes
    Route::get('/patient/video/{booking}', [CallController::class, 'video'])->name('patient.video');
    Route::get('/patient/voice/{booking}', [CallController::class, 'voice'])->name('patient.voice');
    Route::get('/patient/home/{booking}', [CallController::class, 'home'])->name('patient.home');

    // Patient chat routes
    Route::get('/patient/chat', [ChatController::class, 'index'])->middleware('auth')->name('chat.index');
    Route::post('/patient/chat/send', [ChatController::class, 'store'])->middleware('auth')->name('chat.store1');
    
    // Patient chat API routes for polling
    Route::get('/patient/chat/messages/new', [ChatController::class, 'getNewMessages'])->middleware('auth')->name('patient.chat.messages.new');
    Route::post('/patient/chat/mark-read', [ChatController::class, 'markAsRead'])->middleware('auth')->name('patient.chat.mark.read');
    Route::post('/patient/chat/mark-message-read/{messageId}', [ChatController::class, 'markMessageAsRead'])->middleware('auth')->name('patient.chat.mark.message.read');
    Route::get('/patient/chat/unread-counts', [ChatController::class, 'getUnreadCounts'])->middleware('auth')->name('patient.chat.unread.counts');
    Route::get('/patient/chat/messages/{bookingId}/status', [ChatController::class, 'getMessagesWithStatus'])->middleware('auth')->name('patient.chat.messages.status');
    
    // Add this route for marking all messages in a booking as read
    Route::post('/patient/chat/mark-booking-read/{bookingId}', [ChatController::class, 'markBookingAsRead'])->middleware('auth')->name('patient.chat.mark.booking.read');

    Route::get('patient/appointment/{orderReference}', [BookingController::class, 'verification'])->middleware('auth')->name('patient.appointment.verify');
});

// Shared chat API routes (accessible by both patient and doctor)
Route::middleware(['auth'])->group(function () {
    Route::get('/chat/messages/new', [ChatController::class, 'getNewMessages'])->name('chat.messages.new');
    Route::post('/chat/mark-read', [ChatController::class, 'markAsRead'])->name('chat.mark.read');
    Route::post('/chat/mark-message-read/{messageId}', [ChatController::class, 'markMessageAsRead'])->name('chat.mark.message.read');
    Route::get('/chat/unread-counts', [ChatController::class, 'getUnreadCounts'])->name('chat.unread.counts');
    Route::get('/chat/messages/{bookingId}/status', [ChatController::class, 'getMessagesWithStatus'])->name('chat.messages.status');
    Route::post('/chat/mark-booking-read/{bookingId}', [ChatController::class, 'markBookingAsRead'])->name('chat.mark.booking.read');
    Route::get('/notifications/messages', [ChatController::class, 'getMessageNotifications'])->name('notifications.messages');

    Route::post('/call/invite/{booking}', [CallController::class, 'invite'])->name('call.invite');
    Route::get('/call/invites/new', [CallController::class, 'getNewInvites'])->name('call.invites.new');
    Route::post('/call/invites/{invite}/seen', [CallController::class, 'markInviteSeen'])->name('call.invites.seen');
});

Route::post('/call/signal/{booking}', [CallController::class, 'signal'])->middleware('auth')->name('call.signal');

// ✅ CORRECTED: Changed route path to /api/zego-token and using ZegoToken service
Route::middleware('auth')->get('/api/zego-token', function (Request $request) {
    $appId = (int) env('ZEGO_APP_ID');
    $serverSecret = env('ZEGO_SERVER_SECRET');

    $bookingId = $request->query('booking_id');
    
    if (!$bookingId) {
        return response()->json(['error' => 'booking_id is required'], 400);
    }

    $booking = Booking::find($bookingId);
    if (!$booking) {
        return response()->json(['error' => 'Booking not found'], 404);
    }

    $authUserId = (int) $request->user()->id;
    if ($authUserId !== (int) $booking->doctor_id && $authUserId !== (int) $booking->user_id) {
        return response()->json(['error' => 'Unauthorized booking access'], 403);
    }

    if (!$booking->isSessionActive()) {
        return response()->json(['error' => 'Consultation time has ended for this booking'], 403);
    }

    $userId = (string) $authUserId;
    
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
Route::post('/pharmacy/checkout/pay', [PharmacyController::class, 'payment'])->name('pharmacy.payment');
Route::get('/pharmacy/payment/{order}', [PharmacyController::class, 'success'])->name('pharmacy.successfully');
Route::get('/pharmacy/payment/verify/{payment_reference}', [PharmacyController::class, 'verifyPayment'])->name('pharmacy.verify');


Route::post('/doctor/update-availability', [App\Http\Controllers\DoctorGrid::class, 'updateAvailability'])
    ->name('doctor.updateAvailability');

Route::get('/filter/doctors', [DoctorGrid::class, 'filterDoctors'])->name('doctor.filter');

Route::middleware(['auth', 'role:admin'])->get('/run-storage-link', function () {
    abort_unless(app()->environment('local'), 403);
    Artisan::call('storage:link');
    return 'Storage link created successfully!';
});

Route::get('/booking/confirmation/{booking}', [BookingController::class, 'confirmation'])
    ->name('patient.booking.confirmation');
    
Route::get('/token', [BookingController::class, 'showToken']);


// Doctor Profile Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->group(function () {
    // Existing routes
    Route::get('/profile/settings', [ProfileController::class, 'ProSetting'])->name('doctor.profile.settings');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile1'])->name('doctor.profile.update');
    Route::get('/password', [ProfileController::class, 'password'])->name('doctor.password');
    Route::put('/password/update', [ProfileController::class, 'updatePassword'])->name('doctor.password.update');
    
    // New routes for added sections
    Route::put('/speciality/update', [ProfileController::class, 'updateSpeciality'])->name('doctor.speciality.update');
    Route::put('/availability/update', [ProfileController::class, 'updateAvailability'])->name('doctor.availability.update');
    Route::put('/consultation/update', [ProfileController::class, 'updateConsultation'])->name('doctor.consultation.update');
    Route::put('/payment/update', [ProfileController::class, 'updatePayment'])->name('doctor.payment.update');
    Route::put('/experiences/update', [ProfileController::class, 'updateExperiences'])->name('doctor.experiences.update');
    Route::put('/qualifications/update', [ProfileController::class, 'updateQualifications'])->name('doctor.qualifications.update');
});

require __DIR__.'/auth.php';
