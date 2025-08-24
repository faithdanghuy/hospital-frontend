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
$router->add('POST', '/auth/logout', [new AuthController(),'logout']);

// Dashboard
$router->add('GET', '/', [new DashboardController(),'index']);

// User
$router->add('GET', '/users', [new UserController(), 'index'], [Middleware::auth()]);
$router->add('GET', '/users/me', [new UserController(), 'myProfile'], [Middleware::auth()]);
$router->add('GET', '/users/create', [new UserController(), 'create'], [Middleware::auth(), Middleware::roles(['admin'])]);
$router->add('GET', '/users/{id}', [new UserController(), 'show'], [Middleware::auth()]);
$router->add('GET', '/users/{id}/edit', [new UserController(), 'edit'], [Middleware::auth()]);
//$router->add('POST', '/users/{id}/update', [new UserController(), 'update'], [Middleware::auth()]);
//$router->add('POST', '/users/{id}/delete', [new UserController(), 'delete'], [Middleware::auth()]);

// Appointments
$router->add('GET', '/appointments', [new AppointmentController(), 'index'], [Middleware::auth()]);
$router->add('GET', '/appointments/create', [new AppointmentController(), 'create'], [Middleware::auth()]);
$router->add('GET', '/appointments/{id}', [new AppointmentController(), 'show'], [Middleware::auth()]);
$router->add('GET', '/appointments/{id}/edit', [new AppointmentController(), 'edit'], [Middleware::auth()]);

// Medications
$router->add('GET', '/medications', [new MedicationController(), 'index'], [Middleware::auth()]);
$router->add('GET', '/medications/create', [new MedicationController(), 'create'], [Middleware::auth()]);
$router->add('GET', '/medications/{id}', [new MedicationController(), 'show'], [Middleware::auth()]);
$router->add('GET', '/medications/{id}/edit', [new MedicationController(), 'edit'], [Middleware::auth()]);

// Notification
$router->add('GET', '/notifications', [new NotificationController(), 'index'], [Middleware::auth()]);

// Prescription
$router->add('GET', '/prescriptions', [new PrescriptionController(), 'index'], [Middleware::auth()]);
$router->add('GET', '/prescriptions/create', [new PrescriptionController(), 'create'], [Middleware::auth()]);
$router->add('GET', '/prescriptions/{id}', [new PrescriptionController(), 'show'], [Middleware::auth()]);
$router->add('GET', '/prescriptions/{id}/edit', [new PrescriptionController(), 'edit'], [Middleware::auth()]);

$router->dispatch();
