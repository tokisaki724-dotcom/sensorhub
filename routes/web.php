<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SensorController as AdminSensorController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Admin\SuggestionController as AdminSuggestionController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\ProfileController as SuperAdminProfileController;
use App\Http\Controllers\SuperAdmin\SuggestionController as SuperAdminSuggestionController;
use App\Http\Controllers\SuperAdmin\ContentController as SuperAdminContentController;
use App\Http\Controllers\EmailVerificationController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sensors', [SensorController::class, 'index'])->name('sensors.index');
Route::get('/sensors/{slug}', [SensorController::class, 'show'])->name('sensors.show');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/login/verify', [LoginController::class, 'verifyCode'])->name('login.verify');
    Route::post('/login/resend', [LoginController::class, 'resendCode'])->name('login.resend');
    Route::get('/super-admin/login', [LoginController::class, 'showSuperAdminLoginForm'])->name('super-admin.login');
    Route::post('/super-admin/login', [LoginController::class, 'superAdminLogin'])->name('super-admin.login.submit');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// User Routes
Route::middleware(['auth.redirect'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/suggestions', [SuggestionController::class, 'mySuggestions'])->name('suggestions');
    Route::get('/saved-projects', [ProjectController::class, 'saved'])->name('saved');
    Route::post('/suggestions', [SuggestionController::class, 'store'])->name('suggestions.store');
    Route::post('/projects/{project}/save', [ProjectController::class, 'toggleSave'])->name('projects.save');
});

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'show'])->name('verification.notice');
    Route::post('/email/verify', [EmailVerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/email/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Sensors CRUD
    Route::get('/sensors', [AdminSensorController::class, 'index'])->name('sensors.index');
    Route::get('/sensors/create', [AdminSensorController::class, 'create'])->name('sensors.create');
    Route::post('/sensors', [AdminSensorController::class, 'store'])->name('sensors.store');
    Route::get('/sensors/{sensor}/edit', [AdminSensorController::class, 'edit'])->name('sensors.edit');
    Route::put('/sensors/{sensor}', [AdminSensorController::class, 'update'])->name('sensors.update');
    Route::delete('/sensors/{sensor}', [AdminSensorController::class, 'destroy'])->name('sensors.destroy');
    
    // Projects CRUD
    Route::get('/projects', [AdminProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [AdminProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [AdminProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [AdminProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [AdminProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [AdminProjectController::class, 'destroy'])->name('projects.destroy');
    
    // Products CRUD
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    
    // Videos CRUD
    Route::get('/videos', [AdminVideoController::class, 'index'])->name('videos.index');
    Route::get('/videos/create', [AdminVideoController::class, 'create'])->name('videos.create');
    Route::post('/videos', [AdminVideoController::class, 'store'])->name('videos.store');
    Route::get('/videos/{video}/edit', [AdminVideoController::class, 'edit'])->name('videos.edit');
    Route::put('/videos/{video}', [AdminVideoController::class, 'update'])->name('videos.update');
    Route::delete('/videos/{video}', [AdminVideoController::class, 'destroy'])->name('videos.destroy');
    
    // Suggestions Management
    Route::get('/suggestions', [AdminSuggestionController::class, 'index'])->name('suggestions.index');
    Route::get('/suggestions/{suggestion}', [AdminSuggestionController::class, 'show'])->name('suggestions.show');
    Route::put('/suggestions/{suggestion}/status', [AdminSuggestionController::class, 'updateStatus'])->name('suggestions.status');
});

// Super Admin Routes
Route::middleware(['auth', 'super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [SuperAdminProfileController::class, 'show'])->name('profile');
    Route::put('/profile/update', [SuperAdminProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [SuperAdminProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/users', [SuperAdminUserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}/role', [SuperAdminUserController::class, 'updateRole'])->name('users.role');
    Route::delete('/users/{user}', [SuperAdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/suggestions', [SuperAdminSuggestionController::class, 'index'])->name('suggestions.index');
    Route::get('/suggestions/{suggestion}', [SuperAdminSuggestionController::class, 'show'])->name('suggestions.show');
    Route::put('/suggestions/{suggestion}/status', [SuperAdminSuggestionController::class, 'updateStatus'])->name('suggestions.status');
    Route::get('/sensors', [SuperAdminContentController::class, 'sensors'])->name('sensors.index');
    Route::get('/projects', [SuperAdminContentController::class, 'projects'])->name('projects.index');
    Route::get('/products', [SuperAdminContentController::class, 'products'])->name('products.index');
    Route::get('/videos', [SuperAdminContentController::class, 'videos'])->name('videos.index');
    Route::get('/{type}/create', [SuperAdminContentController::class, 'create'])->whereIn('type', ['sensors', 'projects', 'products', 'videos'])->name('content.create');
    Route::post('/{type}', [SuperAdminContentController::class, 'store'])->whereIn('type', ['sensors', 'projects', 'products', 'videos'])->name('content.store');
    Route::get('/{type}/{id}/edit', [SuperAdminContentController::class, 'edit'])->whereIn('type', ['sensors', 'projects', 'products', 'videos'])->name('content.edit');
    Route::put('/{type}/{id}', [SuperAdminContentController::class, 'update'])->whereIn('type', ['sensors', 'projects', 'products', 'videos'])->name('content.update');
    Route::delete('/{type}/{id}', [SuperAdminContentController::class, 'destroy'])->whereIn('type', ['sensors', 'projects', 'products', 'videos'])->name('content.destroy');
});
