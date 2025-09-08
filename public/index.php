<?php

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative = substr($class, $len);
    $file = $base_dir . str_replace('\\','/',$relative) . '.php';
    if (file_exists($file)) require $file;
});

use App\Core\Router;
use App\Core\Middleware;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\UserController;
use App\Controllers\MedicationController;
use App\Controllers\AppointmentController;
use App\Controllers\NotificationController;
use App\Controllers\PrescriptionController;

if (session_status() === PHP_SESSION_NONE) session_start();

$router = new Router();

// Auth
$router->add('GET', '/auth/login', [new AuthController(),'showLoginForm']);
$router->add('POST', '/auth/login', [new AuthController(),'processLogin']);
$router->add('POST', '/auth/logout', [new AuthController(),'logout'], [Middleware::auth()]);
$router->add('GET', '/account/change-password', [new AuthController(),'changePasswordForm'], [Middleware::auth()]);
$router->add('POST', '/account/change-password', [new AuthController(),'changePassword'], [Middleware::auth()]);

// Dashboard
$router->add('GET', '/', [new DashboardController(), 'index'], [Middleware::auth()]);

// User
$router->add('GET', '/account/register', [new UserController(), 'create'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('POST', '/account/register', [new UserController(), 'store'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('GET', '/account', [new UserController(), 'index'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('GET', '/account/profile', [new UserController(), 'myProfile'], [Middleware::auth()]);
$router->add('GET', '/account/edit', [new UserController(), 'edit'], [Middleware::auth()]);
$router->add('POST', '/account/update', [new UserController(), 'update'], [Middleware::auth()]);
$router->add('GET', '/account/detail/{id}', [new UserController(), 'show'], [Middleware::auth(), Middleware::roles(['admin', 'doctor'])]);
$router->add('GET', '/account/edit/{id}', [new UserController(), 'editUser'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('POST', '/account/edit/{id}', [new UserController(), 'updateUser'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('POST', '/account/delete/{id}', [new UserController(), 'delete'], [Middleware::auth(), Middleware::roles(['admin'])]);

// Appointments
$router->add('GET', '/appointments', [new AppointmentController(), 'index'], [Middleware::auth()]);
$router->add('GET', '/appointments/create', [new AppointmentController(), 'create'], [Middleware::auth()]);
$router->add('POST', '/appointments/create', [new AppointmentController(), 'store'], [Middleware::auth()]);
$router->add('GET', '/appointment/{id}', [new AppointmentController(), 'show'], [Middleware::auth()]);
$router->add('GET', '/appointment/edit/{id}', [new AppointmentController(), 'edit'], [Middleware::auth()]);
$router->add('POST', '/appointment/edit/{id}', [new AppointmentController(), 'update'], [Middleware::auth()]);
$router->add('POST', '/appointment/change-status/{id}', [new AppointmentController(), 'changeStatus'], [Middleware::auth(), Middleware::roles(['admin', 'doctor'])]);

// Medications
$router->add('GET', '/medications', [new MedicationController(), 'index'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('GET', '/medication/create', [new MedicationController(), 'create'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('POST', '/medication/create', [new MedicationController(), 'store'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('GET', '/medication/detail/{id}', [new MedicationController(), 'show'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('GET', '/medication/edit/{id}', [new MedicationController(), 'edit'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('POST', '/medication/update/{id}', [new MedicationController(), 'update'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('POST', '/medication/delete/{id}', [new MedicationController(), 'delete'], [Middleware::auth(), Middleware::roles(['admin'])]);

// Notification
$router->add('GET', '/notification', [new NotificationController(), 'index'], [Middleware::auth()]);
$router->add('POST', '/notifications/mark-read/{id}', [new NotificationController(), 'markAsRead'], [Middleware::auth()]);

// Prescription
$router->add('GET', '/prescriptions', [new PrescriptionController(), 'index'], [Middleware::auth()]);
$router->add('GET', '/prescription/detail/{id}', [new PrescriptionController(), 'show'], [Middleware::auth()]);
$router->add('GET', '/prescription/create', [new PrescriptionController(), 'create'], [Middleware::auth(), Middleware::roles(['admin', 'doctor'])]);
$router->add('POST', '/prescription/create', [new PrescriptionController(), 'store'], [Middleware::auth(), Middleware::roles(['admin', 'doctor'])]);
$router->add('GET', '/prescription/edit/{id}', [new PrescriptionController(), 'edit'], [Middleware::auth(), Middleware::roles(['admin', 'doctor'])]);
$router->add('POST', '/prescription/update/{id}', [new PrescriptionController(), 'update'], [Middleware::auth(), Middleware::roles(['admin', 'doctor'])]);
$router->add('POST', '/prescription/delete/{id}', [new PrescriptionController(), 'delete'], [Middleware::auth(), Middleware::roles(['admin', 'doctor'])]);

$router->dispatch();
