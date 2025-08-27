<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Services\ApiClient;

class MedicationController extends Controller {
    // Get all med data
    public function index() {
        $api = new ApiClient($this->config);
        $res = $api->get('MEDICATION_SERVICE', '/medications');
        $items = ($res['data'] ?? [])['items'] ?? ($res['data'] ?? []);
        return $this->view('medications/index', compact('items'));
    }

    // Create a new medication
    public function create() {
        return $this->view('medications/create');
    }

    // Store a new medication
    public function store() {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $payload = $_POST;
        unset($payload['_csrf']);
        
        $res = $api->post('MEDICATION_SERVICE', '/medications', $payload);
        if (($res['status'] ?? 500) < 300) 
            return $this->redirect('/medications');
        $error = $res['data']['message'] ?? 'Create failed';
        return $this->view('medications/create', compact('error'));
    }

    // Edit an existing medication
    public function edit($id) {
        $api = new ApiClient($this->config);
        if ($this->isPost()) {
            $this->requireCsrf();
            $payload = $_POST; unset($payload['_csrf']);
            $res = $api->put('MEDICATION_SERVICE', '/medications/' . urlencode($id), $payload);
            if (($res['status'] ?? 500) < 300) return $this->redirect('/medications');
            $error = $res['data']['message'] ?? 'Update failed';
            $item = $payload;
            return $this->view('medications/edit', compact('item','error'));
        }
        $res = $api->get('MEDICATION_SERVICE', '/medications/' . urlencode($id));
        $item = $res['data'] ?? [];
        return $this->view('medications/edit', compact('item'));
    }

    // Show medication details
    public function show($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('MEDICATION_SERVICE', '/medications/' . urlencode($id));
        $item = $res['data'] ?? [];
        return $this->view('medications/show', compact('item'));
    }

    // Delete a medication
    public function delete($id) {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $api->delete('MEDICATION_SERVICE', '/medications/' . urlencode($id));
        return $this->redirect('/medications');
    }
}
