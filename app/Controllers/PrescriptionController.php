<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Middleware;
use App\Services\ApiClient;

class PrescriptionController extends Controller {
    // Get app prescription data
    public function index() {
        $api = new ApiClient($this->config);
        $res = $api->get('PRESCRIPTION_SERVICE', '/prescriptions');
        $items = ($res['data'] ?? [])['items'] ?? ($res['data'] ?? []);
        return $this->view('prescriptions/index', compact('items'));
    }

    // Create a new prescription
    public function create() {
        return $this->view('prescriptions/create');
    }

    // Store a new prescription
    public function store() {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $payload = $_POST;
        unset($payload['_csrf']);
        
        $res = $api->post('PRESCRIPTION_SERVICE', '/prescriptions', $payload);
        if (($res['status'] ?? 500) < 300) 
            return $this->redirect('/prescriptions');
        $error = $res['data']['message'] ?? 'Create failed';
        return $this->view('prescriptions/create', compact('error'));
    }

    public function edit($id) {
        $api = new ApiClient($this->config);
        if ($this->isPost()) {
            $this->requireCsrf();
            $payload = $_POST; unset($payload['_csrf']);
            $res = $api->put('PRESCRIPTION_SERVICE', '/prescriptions/' . urlencode($id), $payload);
            if (($res['status'] ?? 500) < 300) return $this->redirect('/prescriptions');
            $error = $res['data']['message'] ?? 'Update failed';
            $item = $payload;
            return $this->view('prescriptions/edit', compact('item','error'));
        }
        $res = $api->get('PRESCRIPTION_SERVICE', '/prescriptions/' . urlencode($id));
        $item = $res['data'] ?? [];
        return $this->view('prescriptions/edit', compact('item'));
    }
    public function delete($id) {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $api->delete('PRESCRIPTION_SERVICE', '/prescriptions/' . urlencode($id));
        return $this->redirect('/prescriptions');
    }
    public function show($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('PRESCRIPTION_SERVICE', '/prescriptions/' . urlencode($id));
        $item = $res['data'] ?? [];
        return $this->view('prescriptions/show', compact('item'));
    }
}
