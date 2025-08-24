<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Services\ApiClient;

class ReportController extends Controller {
    public function index() {
        $api = new ApiClient($this->config);
        $patientsByMonth = $api->get('REPORT_SERVICE','/patients/monthly');
        $prescriptions = $api->get('REPORT_SERVICE','/prescriptions/monthly');
        $patientsData = $patientsByMonth['data'] ?? [];
        $prescData = $prescriptions['data'] ?? [];
        return $this->view('reports/index', compact('patientsData','prescData'));
    }
}
