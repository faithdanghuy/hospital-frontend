<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Auth;
use App\Services\ApiClient;

class MedRecordController extends Controller {
    // Get all medical records
    public function index() {
        $api = new ApiClient($this->config);
        $res = $api->get('MEDICAL_RECORD_SERVICE', '/medical-records');
        $items = $res['data'] ?? [];
        return $this->view('med-records/index', compact('items'));
    }

    // Show the create medical record form
    public function create() {
        return $this->view('med-records/create');
    }

    // Process the create medical record functionality
    public function store(){
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $payload = $_POST;
        unset($payload['_csrf']);

        $res = $api->post('APPOINTMENT_SERVICE', '/appointments', $payload);
        if (($res['status'] ?? 500) < 300) {
            return $this->redirect('/appointments');
        }

        $error = $res['data']['message'] ?? 'Create appointment failed';
        return $this->view('appointments', compact('error'));
    }

    // Show a medical record
    public function edit($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('MEDICAL_RECORD_SERVICE', '/medical-records/' . urlencode($id));
        $item = $res['data'] ?? [];
        return $this->view('medical-records/edit', compact('item'));
    }

    public function update($id) {
        if ($this->isPost()) {
            $this->requireCsrf();
            $api = new ApiClient($this->config);
            $payload = $_POST;
            unset($payload['_csrf']);
            $res = $api->put('MEDICAL_RECORD_SERVICE', '/medical-records/' . urlencode($id), $payload);
            if (($res['status'] ?? 500) < 300) {
                return $this->redirect('/medical-records');
            }
            $error = $res['data']['message'] ?? 'Update medical record failed';
            return $this->view('medical-records/edit', compact('error'));
        }
        return $this->redirect('/medical-records/' . urlencode($id) . '/edit');
    }

    // Show a medical record
    public function show($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('MEDICAL_RECORD_SERVICE', '/medical-records/' . urlencode($id));
        $item = $res['data'] ?? [];
        return $this->view('medical-records/show', compact('item'));
    }

    // Delete a medical record
    public function delete($id) {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $api->delete('MEDICAL_RECORD_SERVICE', '/medical-records/' . urlencode($id));
        return $this->redirect('/medical-records');
    }
}
