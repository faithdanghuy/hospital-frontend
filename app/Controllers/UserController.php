<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Middleware;
use App\Services\ApiClient;

class UserController extends Controller {
    public function index() {
        $api = new ApiClient($this->config);
    
        $page = $_GET['page'] ?? 1;
        $limit = $_GET['limit'] ?? 10;

        $res = $api->get('AUTH_SERVICE', '/account/filter', [
            'page' => $page,
            'limit' => $limit
        ]);
    
        $items = ($res['data'] ?? [])['items'] ?? [];
        $total = ($res['data'] ?? [])['total'] ?? 0;
    
        return $this->view('users/index', compact('items', 'page', 'limit', 'total'));
    }
    public function create() {
        if ($this->isPost()) {
            $this->requireCsrf();
            $api = new ApiClient($this->config);
            $payload = $_POST;
            unset($payload['_csrf']);
            $res = $api->post('AUTH_SERVICE', '/auth/register', $payload);
            
            if (($res['status'] ?? 500) < 300) {
                return $this->redirect('/users');
            }
            $error = $res['data']['message'] ?? 'Create user failed';
            $old = $payload;
            return $this->view('users/create', compact('error', 'old'));
        }
        return $this->view('users/create');
    }
    public function edit($id) {
        $api = new ApiClient($this->config);
        if ($this->isPost()) {
            $this->requireCsrf();
            $payload = $_POST; unset($payload['_csrf']);
            $res = $api->put('AUTH_SERVICE', '/users/' . urlencode($id), $payload);
            if (($res['status'] ?? 500) < 300) return $this->redirect('/users');
            $error = $res['data']['message'] ?? 'Update failed';
            $item = $payload;
            return $this->view('users/edit', compact('item','error'));
        }
        $res = $api->get('AUTH_SERVICE', '/users/' . urlencode($id));
        $item = $res['data'] ?? [];
        return $this->view('users/edit', compact('item'));
    }
    public function delete($id) {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $api->delete('AUTH_SERVICE', '/users/' . urlencode($id));
        return $this->redirect('/users');
    }
    public function myProfile() {
        $api = new ApiClient($this->config);
        $res = $api->get('AUTH_SERVICE', '/account/detail');
        $item = $res['data'] ?? $res ?? [];
        return $this->view('users/show', compact('item'));
    }
    public function show($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('AUTH_SERVICE', '/users/' . urlencode($id));
        $item = $res['data'] ?? [];
        return $this->view('users/show', compact('item'));
    }
}
