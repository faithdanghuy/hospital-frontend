<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Auth;

class DashboardController extends Controller {
    public function showAdminDashboard() {
        $user = Auth::user();
        return $this->view('dashboard/admin', ['user' => $user]);
    }

    public function showDoctorDashboard() {
        $user = Auth::user();
        return $this->view('dashboard/doctor', ['user' => $user]);
    }

    public function showPatientDashboard() {
        $user = Auth::user();
        return $this->view('dashboard/patient', ['user' => $user]);
    }
}
