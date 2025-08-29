<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Services\ApiClient;
use App\Core\Auth;

class DashboardController extends Controller {    
    public function index() {
        $api = new ApiClient($this->config);
        $patient_stats = $api->get('REPORT_SERVICE', 'report/patients');
        $prescription_stats = $api->get('REPORT_SERVICE', 'report/prescriptions');
        $appointment_stats = $api->get('REPORT_SERVICE', 'report/appointments');
        $user = Auth::user();
        
        return $this->view('dashboard/home', [
            'user' => $user,
            'patient_stats' => $patient_stats,
            'prescription_stats' => $prescription_stats,
            'appointment_stats' => $appointment_stats
        ]);
    }
}
