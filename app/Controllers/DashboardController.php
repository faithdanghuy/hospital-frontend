<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Services\ApiClient;
use App\Core\Auth;

class DashboardController extends Controller {    
    public function index() {
        $api = new ApiClient($this->config);

        if (Auth::role() === 'admin') {
            $current_month = date('n');
            $current_year = date('Y');
            $patient_stats = $api->get('REPORT_SERVICE', "/report/patients?month={$current_month}&year={$current_year}")['data']['data'];
            $prescription_stats = $api->get('REPORT_SERVICE', "/report/prescriptions?month={$current_month}&year={$current_year}")['data']['data'];
            $appointment_stats = $api->get('REPORT_SERVICE', "/report/appointments?month={$current_month}&year={$current_year}")['data']['data'];
            $user = Auth::user();

            return $this->view('dashboard/home', [
                'user' => $user,
                'patient_stats' => $patient_stats,
                'prescription_stats' => $prescription_stats,
                'appointment_stats' => $appointment_stats,
            ]);
        }
        else {
            $app = $api->get('APPOINTMENT_SERVICE', '/appointment/filter')['data']['data']['rows'] ?? [];
            $pre = $api->get('PRESCRIPTION_SERVICE', '/prescription/filter')['data']['data']['rows'] ?? [];
            // echo '<pre>';
            // print_r($app);
            // echo '</pre>';
            // exit;
            return $this->view('dashboard/home', [
                'pre' => $pre,
                'app' => $app,
                'total_app' => count($app),
                'total_pre' => count($pre)
            ]);
        }
    }
}
