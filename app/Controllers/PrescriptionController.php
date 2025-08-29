<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Middleware;
use App\Services\ApiClient;

class PrescriptionController extends Controller {
    // Get app prescription data
    public function index() {
        $api = new ApiClient($this->config);
        $res = $api->get('PRESCRIPTION_SERVICE', '/prescription/filter');
        $items = $res['data']['data']['rows'] ?? [];
        return $this->view('prescriptions/index', compact('items'));
    }

    // Get prescription detail
    public function show($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('PRESCRIPTION_SERVICE', '/prescription/detail/' . urlencode($id));
        $item = $res['data']['data'] ?? [];
        return $this->view('prescriptions/show', compact('item'));
    }

    // Create a new prescription
    public function create() {
        $api = new ApiClient($this->config);
        $doctors = $api->get('AUTH_SERVICE', '/account/doctors');
        $patients = $api->get('AUTH_SERVICE', '/account/patients');
        $meds = $api->get('PRESCRIPTION_SERVICE', '/medication/filter');

        $doctors = $doctors['data']['data']['rows'] ?? [];
        $patients = $patients['data']['data']['rows'] ?? [];
        $meds = $meds['data']['data']['rows'] ?? [];
        return $this->view('prescriptions/create', compact('doctors', 'patients', 'meds'));
    }

    // Store a new prescription
    public function store() {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $payload = $_POST;
        unset($payload['_csrf']);

        foreach ($payload['medications'] as &$med) {
            $med['quantity'] = (int) $med['quantity'];
        }
        unset($med);
        
        $res = $api->post('PRESCRIPTION_SERVICE', '/prescription/create', $payload);
        if (($res['status'] ?? 500) < 300) {
            return $this->redirect('/prescriptions');
        }

        $error = $res['data']['message'] ?? 'Create failed';
        return $this->view('prescriptions/create', compact('error'));
    }

    public function edit($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('PRESCRIPTION_SERVICE', '/prescription/detail/' . urlencode($id));
        $meds = $api->get('PRESCRIPTION_SERVICE', '/medication/filter');

        $item = $res['data']['data'] ?? [];
        $meds = $meds['data']['data']['rows'] ?? [];
        return $this->view('prescriptions/edit', compact('item', 'meds'));
    }

    public function update($id){
        $api = new ApiClient($this->config);
        $this->requireCsrf();
        $payload = $_POST; 
        unset($payload['_csrf']);

        foreach ($payload['medications'] as &$med) {
            $med['quantity'] = (int) $med['quantity'];
        }
        unset($med);
        $res = $api->patch('PRESCRIPTION_SERVICE', '/prescription/update/' . urlencode($id), $payload);
        if (($res['status'] ?? 500) < 300) {
            return $this->redirect('/prescriptions');
        }
        $error = $res['data']['message'] ?? 'Update failed';
        $item = $payload;
        return $this->view('prescriptions/edit', compact('item','error'));
    }

    // Delete a prescription
    public function delete($id) {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $api->delete('PRESCRIPTION_SERVICE', '/prescription/delete/' . urlencode($id));
        return $this->redirect('/prescriptions');
    }
}
