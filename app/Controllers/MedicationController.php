<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Services\ApiClient;

class MedicationController extends Controller {
    // Get all med data
    public function index() {
        $api = new ApiClient($this->config);
        $res = $api->get('PRESCRIPTION_SERVICE', '/medication/filter', [
            'page' => $_GET['page'] ?? 1,
            'limit' => $_GET['limit'] ?? 10,
        ]);
        $data  = $res['data']['data'] ?? [];
        $items = $data['rows'] ?? [];
        
        return $this->view('medication/index', [
            'items' => $items,
            'limit' => $data['limit'] ?? 10,
            'page'  => $data['page'] ?? 1,
            'total_pages' => $data['total_pages'] ?? 1,
            'total_rows'  => $data['total_rows'] ?? count($items),
        ]);
    }

    // Show medication details
    public function show($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('PRESCRIPTION_SERVICE', '/medication/detail/' . urlencode($id));
        $item = $res['data']['data'] ?? [];
        return $this->view('medication/show', compact('item'));
    }

    // Create a new medication
    public function create() {
        return $this->view('medication/create');
    }

    // Store a new medication
    public function store() {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $payload = $_POST;
        unset($payload['_csrf']);

        $payload = [
            "drug_name"   => $_POST['drug_name'],
            "description" => $_POST['description'],
            "stock"       => (int) $_POST['stock'],
            "unit"        => $_POST['unit']
        ];

        $res = $api->post('PRESCRIPTION_SERVICE', '/medication/create', $payload);
        if (($res['status'] ?? 500) < 300) {
            return $this->redirect('/medications');
        }
        $error = $res['data']['message'] ?? 'Create failed';
        return $this->view('medication/create', compact('error'));
    }

    // Edit an existing medication
    public function edit($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('PRESCRIPTION_SERVICE', '/medication/detail/' . urlencode($id));
        $item = $res['data']['data'] ?? [];
        return $this->view('medication/edit', compact('item'));
    }

    // Update an existing medication
    public function update($id) {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $payload = $_POST;
        unset($payload['_csrf']);

        $payload = [
            "drug_name"   => $_POST['drug_name'],
            "description" => $_POST['description'],
            "stock"       => (int) $_POST['stock'],
            "unit"        => $_POST['unit']
        ];

        $res = $api->patch('PRESCRIPTION_SERVICE', '/medication/update/' . urlencode($id), $payload);
        if (($res['status'] ?? 500) < 300) {
            return $this->redirect('/medications');
        }
        $error = $res['data']['message'] ?? 'Update failed';
        return $this->view('medication/edit', compact('error'));
    }

    // Delete a medication
    public function delete($id) {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $api->delete('PRESCRIPTION_SERVICE', '/medication/delete/' . urlencode($id));
        return $this->redirect('/medications');
    }
}
