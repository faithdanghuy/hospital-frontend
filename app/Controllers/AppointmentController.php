<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Auth;
use App\Core\Middleware;
use App\Services\ApiClient;

class AppointmentController extends Controller {
    // Get all appointments
    public function index() {
        $api = new ApiClient($this->config);

        $user = Auth::user();
        $payload = [
            'role' => $user['role'],
            'id'   => $user['id']
        ];

        $res = $api->post('APPOINTMENT_SERVICE', '/appointments', $payload);
        $items = $res['data'] ?? [];

        return $this->view('appointments/index', compact('items'));
    }

    // Show the create appointment form
    public function create() {
        return $this->view('appointments/create');
    }

    // Process the create appointment functionality
    public function store(){
        if ($this->isPost()) {
            $this->requireCsrf();
            $api = new ApiClient($this->config);
            $payload = $_POST;
            unset($payload['_csrf']);
            $res = $api->post('APPOINTMENT_SERVICE', '/appointments', $payload);
            if (($res['status'] ?? 500) < 300) 
                return $this->redirect('/appointments');
            $error = $res['data']['message'] ?? 'Create appointment failed';
            return $this->view('appointments/create', compact('error'));
        }
        return $this->view('appointments/create');
    }

    public function edit($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('APPOINTMENT_SERVICE', '/appointments/' . urlencode($id));
        $item = $res['data'] ?? [];
        return $this->view('appointments/edit', compact('item'));
    }

    public function update($id) {
        if ($this->isPost()) {
            $this->requireCsrf();
            $api = new ApiClient($this->config);
            $payload = $_POST;
            unset($payload['_csrf']);
            $res = $api->put('APPOINTMENT_SERVICE', '/appointments/' . urlencode($id), $payload);
            if (($res['status'] ?? 500) < 300) 
                return $this->redirect('/appointments');
            $error = $res['data']['message'] ?? 'Update appointment failed';
            return $this->view('appointments/edit', compact('error'));
        }
        return $this->redirect('/appointments/' . urlencode($id) . '/edit');
    } 

    public function show($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('APPOINTMENT_SERVICE', '/appointments/' . urlencode($id));
        $item = $res['data'] ?? [];
        return $this->view('appointments/show', compact('item'));
    }

    public function delete($id) {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $api->delete('APPOINTMENT_SERVICE', '/appointments/' . urlencode($id));
        return $this->redirect('/appointments');
    }
}
