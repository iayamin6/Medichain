<?php
// Ensure there is no closing PHP tag at the end of the file


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AppointmentController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\PatientRecordController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\TelemedicineController;
use App\Http\Controllers\MedicalTravelController;
use App\Http\Controllers\ProviderViewController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\Doctor\DoctorDashboardController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\ProfileController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\OnlineConsultationController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\HealthMonitoringController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Doctor\DoctorAppointmentController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\Doctor\DoctorPatientController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\Doctor\DoctorRecordController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\Doctor\DoctorTelemedicineController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\Doctor\DoctorSettingController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\Doctor\PrescriptionController; // Ensure this controller exists in the specified namespace

// If the class does not exist, create it in the specified namespace

// Add this line to register all auth routes including password reset
Auth::routes();

Route::get('/', function () {
    return view('dashboard');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/patient/records', [PatientRecordController::class, 'index'])->name('patient.records');
    Route::get('/patient/records/{record}', [PatientRecordController::class, 'show'])->name('patient.records.show');
    Route::post('/patient/records/{record}/share', [PatientRecordController::class, 'share'])
        ->name('patient.records.share')
        ->middleware('auth');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/slots', [AppointmentController::class, 'getAvailableSlots'])->name('appointments.slots');
    Route::post('/appointments/book-slot', [AppointmentController::class, 'bookSlot'])->name('appointments.bookSlot');
    Route::get('/emergency', [EmergencyController::class, 'index'])->name('emergency');
    Route::post('/emergency/book-ambulance', [EmergencyController::class, 'bookAmbulance'])
        ->name('emergency.book-ambulance')
        ->middleware(['auth']);
    Route::get('/telemedicine', [TelemedicineController::class, 'index'])->name('telemedicine');
    Route::get('/medical-travel', [MedicalTravelController::class, 'index'])->name('medical.travel');
    Route::get('/get-doctor-slots', [AppointmentController::class, 'getAvailableSlots'])->name('doctor.slots');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/consultations', [OnlineConsultationController::class, 'index'])->name('consultations.index');
    Route::get('/consultation/{appointment}', [OnlineConsultationController::class, 'join'])->name('consultation.join');
    Route::post('/consultation/{appointment}/prescription', [OnlineConsultationController::class, 'savePrescription'])
        ->name('consultation.savePrescription');
    Route::get('/health/monitor', [HealthMonitoringController::class, 'index'])->name('health.monitoring');
    Route::post('/health/metric', [HealthMonitoringController::class, 'logMetric'])->name('health.log-metric');
    Route::post('/health/medication', [HealthMonitoringController::class, 'addMedication'])->name('health.add-medication');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/emergency', [EmergencyController::class, 'index'])->name('emergency.index');
    Route::get('/emergency/book', [EmergencyController::class, 'bookForm'])->name('emergency.book');
    Route::post('/emergency/book-ambulance', [EmergencyController::class, 'bookAmbulance'])->name('emergency.book-ambulance');
    Route::get('/consultations', [OnlineConsultationController::class, 'index'])->name('consultations.index');
    Route::get('/consultation/{appointment}/join', [OnlineConsultationController::class, 'join'])->name('consultation.join');
    Route::get('/consultation/{id}/join', [OnlineConsultationController::class, 'join'])->name('consultation.join');
    Route::get('/consultations/join/{id}', [OnlineConsultationController::class, 'index'])->name('consultation.join');
    Route::post('/emergency/book-ambulance', [EmergencyController::class, 'bookAmbulance'])
        ->name('emergency.book-ambulance');
});

Route::get('/provider/record/{record}/{token}', [ProviderViewController::class, 'show'])
    ->name('provider.view.record')
    ->middleware('signed');

// Remove duplicate route groups and combine doctor routes
Route::middleware(['auth', 'App\Http\Middleware\DoctorMiddleware'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointments', [DoctorAppointmentController::class, 'index'])->name('appointments');
    Route::get('/appointments/{appointment}', [DoctorAppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{appointment}/update', [DoctorAppointmentController::class, 'updateStatus'])->name('appointments.update');
    Route::get('/patients', [DoctorPatientController::class, 'index'])->name('patients');
    Route::get('/patients/{user}', [DoctorPatientController::class, 'show'])->name('patients.show');
    Route::get('/records', [DoctorRecordController::class, 'index'])->name('records');
    Route::post('/records/search', [DoctorRecordController::class, 'search'])->name('records.search');
    Route::get('/records/{appointment}', [DoctorRecordController::class, 'show'])->name('records.show');
    Route::post('/records/{appointment}', [DoctorRecordController::class, 'store'])->name('records.store');
    Route::get('/telemedicine', [DoctorTelemedicineController::class, 'index'])->name('telemedicine');
    Route::get('/telemedicine/{appointment}', [DoctorTelemedicineController::class, 'show'])->name('telemedicine.show');
    Route::post('/telemedicine/{appointment}/end', [DoctorTelemedicineController::class, 'endSession'])->name('telemedicine.end');
    Route::get('/settings', [DoctorSettingController::class, 'index'])->name('settings');
    Route::post('/settings', [DoctorSettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/password', [DoctorSettingController::class, 'updatePassword'])->name('settings.password');
    Route::get('/prescriptions/create/{appointment}', [PrescriptionController::class, 'create'])->name('prescriptions.create');
    Route::post('/prescriptions/{appointment}', [PrescriptionController::class, 'store'])->name('prescriptions.store');
});

// Remove or comment out the duplicate admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/doctors', [AdminController::class, 'doctors'])->name('doctors');
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
    Route::get('/hospitals', [AdminController::class, 'hospitals'])->name('hospitals');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
});