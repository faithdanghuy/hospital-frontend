<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Middleware;
use App\Services\ApiClient;

class AppointmentController extends Controller {
    public function index() {
        $api = new ApiClient($this->config);
        $res = $api->get('APPOINTMENT_SERVICE', '/appointments');
        $items = ($res['data'] ?? [])['items'] ?? ($res['data'] ?? []);
        return $this->view('appointments/index', compact('items'));
    }
    public function create() {
        if ($this->isPost()) {
            $this->requireCsrf();
            $api = new ApiClient($this->config);
            $payload = $_POST;
            unset($payload['_csrf']);
            $res = $api->post('APPOINTMENT_SERVICE', '/appointments', $payload);
            if (($res['status'] ?? 500) < 300) return $this->redirect('/appointments');
            $error = $res['data']['message'] ?? 'Create failed';
            return $this->view('appointments/create', compact('error'));
        }
        return $this->view('appointments/create');
    }
    public function edit($id) {
        $api = new ApiClient($this->config);
        if ($this->isPost()) {
            $this->requireCsrf();
            $payload = $_POST; unset($payload['_csrf']);
            $res = $api->put('APPOINTMENT_SERVICE', '/appointments/' . urlencode($id), $payload);
            if (($res['status'] ?? 500) < 300) return $this->redirect('/appointments');
            $error = $res['data']['message'] ?? 'Update failed';
            $item = $payload;
            return $this->view('appointments/edit', compact('item','error'));
        }
        $res = $api->get('APPOINTMENT_SERVICE', '/appointments/' . urlencode($id));
        $item = $res['data'] ?? [];
        return $this->view('appointments/edit', compact('item'));
    }
    public function delete($id) {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $api->delete('APPOINTMENT_SERVICE', '/appointments/' . urlencode($id));
        return $this->redirect('/appointments');
    }
    public function show($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('APPOINTMENT_SERVICE', '/appointments/' . urlencode($id));
        $item = $res['data'] ?? [];
        return $this->view('appointments/show', compact('item'));
    }
}
