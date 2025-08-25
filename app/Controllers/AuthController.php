<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Services\ApiClient;

class AuthController extends Controller {
    // Show login form
    public function showLoginForm() {
        $error = $_SESSION['error'] ?? null;
        $old   = $_SESSION['old'] ?? [];

        // flush ngay sau khi lấy ra
        unset($_SESSION['error'], $_SESSION['old']);

        return $this->view('auth/login', compact('error', 'old'));
    }

    // Process the login functionality
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

        $_SESSION['error'] = $res['data']['message'] ?? 'Incorrect phone or password';
        $_SESSION['old']   = ['phone' => $payload['phone']];

        return $this->redirect('/auth/login');
    }

    // Get change password form
    public function changePasswordForm() {
        return $this->view('auth/change-password');
    }

    // Process the change password functionality
    public function changePassword() {
        $this->requireCsrf();

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'New password and confirm password do not match.';
            return $this->redirect('/account/edit');
        }

        $api = new ApiClient($this->config);
        $payload = [
            'current_password' => $currentPassword,
            'new_password' => $newPassword
        ];

        $res = $api->patch('AUTH_SERVICE', '/auth/change-password', $payload, [
            'Authorization: Bearer ' . (Auth::user()['access_token'] ?? '')
        ]);

        if (($res['status'] ?? 500) === 200) {
            $_SESSION['success'] = 'Password changed successfully.';
            return $this->redirect('/account/edit');
        } else {
            $_SESSION['error'] = $res['data']['message'] ?? 'Failed to change password.';
            return $this->redirect('/account/edit');
        }
    }

    // Logout the current user
    public function logout() {
        Auth::logout();
        return $this->redirect('/auth/login');
    }
}
