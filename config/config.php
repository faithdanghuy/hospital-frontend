<?php
$appUrl = getenv('APP_URL') ?: 'https://43308dbb3a7f.ngrok-free.app';

return [
    // App settings
    'APP_DEBUG' => getenv('APP_DEBUG') ?: true,
    'APP_URL'   => $appUrl,

    // Base URLs for Go microservices
    'AUTH_SERVICE'         => $appUrl . '/user-service',
    'MEDICATION_SERVICE'   => $appUrl . '/medication-service',
    'APPOINTMENT_SERVICE'  => $appUrl . '/appointment-service',
    'PRESCRIPTION_SERVICE' => $appUrl . '/prescription-service',
    'NOTIFICATION_SERVICE' => $appUrl . '/noti-service',
    'REPORT_SERVICE'       => $appUrl . '/report-service',
];
