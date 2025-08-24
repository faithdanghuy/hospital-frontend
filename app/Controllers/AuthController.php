<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Services\ApiClient;

class AuthController extends Controller {
    public function showLoginForm() {
        $error = $_SESSION['error'] ?? null;
        $old   = $_SESSION['old'] ?? [];

        // flush ngay sau khi lấy ra
        unset($_SESSION['error'], $_SESSION['old']);

        return $this->view('auth/login', compact('error', 'old'));
    }

    public function processLogin() {
        $this->requireCsrf();
    
        $api = new ApiClient($this->config);
        $payload = [
            'phone'    => $_POST['phone'] ?? '',
            'password' => $_POST['password'] ?? ''
        ];
    
        $res = $api->post('AUTH_SERVICE', '/auth/login', $payload);
    
        if (($res['status'] ?? 500) === 200 && !empty($res['data']['data']['access_token'])) {
            Auth::login($res['data']['data']);
            return $this->redirect('/');
        }
    
        // Lưu flash error và old input vào session
        $_SESSION['error'] = $res['data']['message'] ?? 'Incorrect phone or password';
        $_SESSION['old']   = ['phone' => $payload['phone']];
    
        // Redirect về login (GET)
        return $this->redirect('/auth/login');
    }

    public function logout() {
        Auth::logout();
        return $this->redirect('/auth/login');
    }
}
