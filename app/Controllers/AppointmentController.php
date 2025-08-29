<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Services\ApiClient;

class AppointmentController extends Controller {
    // Get all appointments
    public function index() {
        $api = new ApiClient($this->config);
        $res = $api->get('APPOINTMENT_SERVICE', '/appointment/filter');
        $items = $res['data']['data']['rows'] ?? [];

        foreach ($items as &$it) {
            if (!empty($it['scheduled_at'])) {
                $dt = new \DateTime($it['scheduled_at']);
                $it['date'] = $dt->format('Y-m-d');
                $it['time'] = $dt->format('H:i');
            }
        }
        unset($it);
        return $this->view('appointments/index', compact('items'));
    }

    // Show appointment details
    public function show($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('APPOINTMENT_SERVICE', '/appointment/detail/' . urlencode($id));
        $item = $res['data']['data'] ?? [];

        if (!empty($item['scheduled_at'])) {
            $dt = new \DateTime($item['scheduled_at']);
            $item['date'] = $dt->format('Y-m-d');
            $item['time'] = $dt->format('H:i');
        }

        if (!empty($item['confirmed_at'])) {
            $dt = new \DateTime($item['confirmed_at']);
            $item['confirmed_date'] = $dt->format('Y-m-d');
            $item['confirmed_time'] = $dt->format('H:i');
        }
        return $this->view('appointments/show', compact('item'));
    }

    // Show the create appointment form
    public function create() {
        $api = new ApiClient($this->config);
        $doctors = $api->get('AUTH_SERVICE', '/account/doctors');
        $patients = $api->get('AUTH_SERVICE', '/account/patients');

        $doctors = $doctors['data']['data']['rows'] ?? [];
        $patients = $patients['data']['data']['rows'] ?? [];
        return $this->view('appointments/create', compact('doctors', 'patients'));
    }

    // Process the create appointment functionality
    public function store(){
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $payload = $_POST;
        unset($payload['_csrf']);
        unset($payload['date']);
        unset($payload['time']);

        $res = $api->post('APPOINTMENT_SERVICE', '/appointment/create', $payload);
        if (($res['status'] ?? 500) < 300) {
            return $this->redirect('/appointments');
        }

        $error = $res['data']['message'] ?? 'Create appointment failed';
        return $this->view('appointments', compact('error'));
    }

    // Show appointment edit form
    public function edit($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('APPOINTMENT_SERVICE', '/appointment/detail/' . urlencode($id));
        $item = $res['data']['data'] ?? [];

        if (!empty($item['scheduled_at'])) {
            $dt = new \DateTime($item['scheduled_at']);
            $item['date'] = $dt->format('Y-m-d');
            $item['time'] = $dt->format('H:i');
        };
        return $this->view('appointments/edit', compact('item'));
    }

    // Update appointment
    public function update($id) {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $payload = $_POST;
        unset($payload['_csrf']);
        unset($payload['date']);
        unset($payload['time']);
     
        $res = $api->patch('APPOINTMENT_SERVICE', '/appointment/edit/' . urlencode($id), $payload);
        if (($res['status'] ?? 500) < 300) {
            return $this->redirect('/appointments');
        }
        $error = $res['data']['message'] ?? 'Update appointment failed';
        return $this->view('appointments/edit', compact('error'));
    } 

    // Change appointment status
    public function changeStatus($id) {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $payload = $_POST;
        unset($payload['_csrf']);
        $res = $api->patch('APPOINTMENT_SERVICE', '/appointment/change-status/' . urlencode($id), $payload);
        if (($res['status'] ?? 500) < 300) {
            return $this->redirect('/appointment/' . urlencode($id));
        }
        $error = $res['data']['message'] ?? 'Change status failed';
        return $this->view('appointments/index', compact('error'));
    }
}
