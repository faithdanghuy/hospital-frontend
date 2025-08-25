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
use App\Controllers\ReportController;

if (session_status() === PHP_SESSION_NONE) session_start();

$router = new Router();

// Auth
$router->add('GET', '/auth/login', [new AuthController(),'showLoginForm']);
$router->add('POST', '/auth/login', [new AuthController(),'processLogin']);
$router->add('POST', '/auth/logout', [new AuthController(),'logout'], [Middleware::auth()]);
$router->add('GET', '/account/change-password', [new AuthController(),'changePasswordForm'], [Middleware::auth()]);
$router->add('POST', '/account/change-password', [new AuthController(),'changePassword'], [Middleware::auth()]);

// Dashboard
$router->add('GET', '/', [new DashboardController(),'showAdminDashboard'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('GET', '/', [new DashboardController(),'showDoctorDashboard'], [Middleware::auth(), Middleware::roles(['doctor'])]);
$router->add('GET', '/', [new DashboardController(),'showPatientDashboard'], [Middleware::auth(), Middleware::roles(['patient'])]);

// User
$router->add('GET', '/account/register', [new UserController(), 'create'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('POST', '/account/register', [new UserController(), 'store'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('GET', '/account', [new UserController(), 'index'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('GET', '/account/profile', [new UserController(), 'myProfile'], [Middleware::auth()]);
$router->add('GET', '/account/edit', [new UserController(), 'edit'], [Middleware::auth()]);
$router->add('POST', '/account/update', [new UserController(), 'update'], [Middleware::auth()]);
$router->add('GET', '/account/detail/{id}', [new UserController(), 'show'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('DELETE', '/account/delete', [new UserController(), 'delete'], [Middleware::auth(), Middleware::roles(['admin'])]);

// Appointments
$router->add('GET', '/appointments', [new AppointmentController(), 'index'], [Middleware::auth()]);
$router->add('GET', '/appointments/create', [new AppointmentController(), 'create'], [Middleware::auth()]);
$router->add('POST', '/appointments/create', [new AppointmentController(), 'store'], [Middleware::auth()]);
$router->add('GET', '/appointments/{id}', [new AppointmentController(), 'show'], [Middleware::auth()]);
$router->add('GET', '/appointments/{id}/edit', [new AppointmentController(), 'edit'], [Middleware::auth()]);

// Medications
$router->add('GET', '/medications', [new MedicationController(), 'index'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('GET', '/medications/create', [new MedicationController(), 'create'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('GET', '/medications/{id}', [new MedicationController(), 'show'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('GET', '/medications/{id}/edit', [new MedicationController(), 'edit'], [Middleware::auth(), Middleware::roles(['admin'])]);

// Notification
$router->add('GET', '/notifications', [new NotificationController(), 'index'], [Middleware::auth()]);
// $router->add('GET', '/notifications/create', [new NotificationController(), 'create'], [Middleware::auth(), Middleware::roles(['admin'])]);
// $router->add('POST', '/notifications', [new NotificationController(), 'store'], [Middleware::auth(), Middleware::roles(['admin'])]);
// $router->add('GET', '/notifications/{id}', [new NotificationController(), 'show'], [Middleware::auth()]);
// $router->add('GET', '/notifications/{id}/edit', [new NotificationController(), 'edit'], [Middleware::auth()]);
// $router->add('POST', '/notifications/{id}/delete', [new NotificationController(), 'delete'], [Middleware::auth(), Middleware::roles(['admin'])]);

// Prescription
$router->add('GET', '/prescriptions', [new PrescriptionController(), 'index'], [Middleware::auth()]);
$router->add('GET', '/prescriptions/create', [new PrescriptionController(), 'create'], [Middleware::auth(), Middleware::roles(['admin', 'doctor'])]);
$router->add('POST', '/prescriptions', [new PrescriptionController(), 'store'], [Middleware::auth(), Middleware::roles(['admin', 'doctor'])]);
$router->add('GET', '/prescriptions/{id}', [new PrescriptionController(), 'show'], [Middleware::auth()]);
$router->add('GET', '/prescriptions/{id}/edit', [new PrescriptionController(), 'edit'], [Middleware::auth(), Middleware::roles(['admin', 'doctor'])]);

$router->dispatch();
