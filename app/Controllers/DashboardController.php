<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Auth;

class DashboardController extends Controller {    
    public function index() {
        $user = Auth::user();
        return $this->view('dashboard/home', ['user' => $user]);
    }
}
