<?php
$appUrl = getenv('APP_URL') ?: 'https://c8ba054f0ba5.ngrok-free.app';

return [
    // App settings
    'APP_DEBUG' => getenv('APP_DEBUG') ?: true,
    'APP_URL'   => $appUrl,

    // Base URLs for Go microservices
    'AUTH_SERVICE'           => $appUrl . '/user-service',
    'APPOINTMENT_SERVICE'    => $appUrl . '/appointment-service',
    'PRESCRIPTION_SERVICE'   => $appUrl . '/prescription-service',
    'NOTIFICATION_SERVICE'   => $appUrl . '/noti-service',
    'MEDICAL_RECORD_SERVICE' => $appUrl . '/medical-record-service',
    'REPORT_SERVICE'         => $appUrl . '/report-service',
];
