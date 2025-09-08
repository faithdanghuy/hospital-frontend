<?php
$appUrl = getenv('APP_URL') ?: 'https://0bf0a5f3c70a.ngrok-free.app';

return [
    // App settings
    'APP_DEBUG' => getenv('APP_DEBUG') ?: true,
    'APP_URL'   => $appUrl,

    // Base URLs for Go microservices
    'AUTH_SERVICE'           => $appUrl . '/user-service',
    'APPOINTMENT_SERVICE'    => $appUrl . '/appointment-service',
    'PRESCRIPTION_SERVICE'   => $appUrl . '/prescription-service',
    'NOTIFICATION_SERVICE'   => $appUrl . '/notify-service',
    'REPORT_SERVICE'         => $appUrl . '/report-service',
];
