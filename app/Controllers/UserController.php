<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Auth;
use App\Core\Middleware;
use App\Services\ApiClient;

class UserController extends Controller {
    // Get all users
    public function index() {
        $api = new ApiClient($this->config);

        $page = $_GET['page'] ?? 1;
        $limit = $_GET['limit'] ?? 10;
        $sort = $_GET['sort'] ?? 'id:asc';

        $res = $api->get('AUTH_SERVICE', '/account/filter', [
            'page' => (int)$page,
            'limit' => (int)$limit,
            'sort' => $sort
        ]);

        $data = $res['data']['data'] ?? [];
        $items = $data['rows'] ?? [];

        // echo '<pre>';
        // var_dump($res);
        // echo '</pre>';
        // exit;

        return $this->view('users/index', [
            'items' => $items,
            'limit' => $data['limit'] ?? null,
            'page' => $data['page'] ?? null,
            'total_pages' => $data['total_pages'] ?? null,
            'total_rows' => $data['total_rows'] ?? null,
        ]);
    }

    // Open a create user form
    public function create() {
        return $this->view('users/create');
    }

    // Creating the user
    public function store() {
        if (!$this->isPost()) {
            return $this->redirect('/users/create');
        }

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

    // Open current user edit form
    public function edit() {
        $api = new ApiClient($this->config);
        $res = $api->get('AUTH_SERVICE', '/account/profile');
        $item = $res['data'] ?? [];
        // echo '<pre>';
        // var_dump($res['data']['data']['user']);
        // echo '</pre>';
        // exit;
        return $this->view('users/edit', compact('item'));
    }

    // Update current user profile
    public function update() {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $payload = $_POST;
        unset($payload['_csrf']);
        $res = $api->put('AUTH_SERVICE', '/account/update', $payload);

        if (($res['status'] ?? 500) < 300) {
            return $this->redirect('/users');
        }
        $error = $res['data']['message'] ?? 'Update user failed';
        $old = $payload;
        return $this->view('users/edit', compact('error', 'old', 'id'));
    }

    // Open current user profile
    public function myProfile() {
        $api = new ApiClient($this->config);
        //$user = Auth::user();
        $res = $api->get('AUTH_SERVICE', '/account/profile');
        $item = $res['data'] ?? $res ?? [];
        return $this->view('users/show', ['item' => $item]);
    }
    
    // Open user detail by id
    public function show($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('AUTH_SERVICE', '/account/detail/' . urlencode($id));
        $item = $res['data']['data']['user'] ?? [];
        return $this->view('users/show', compact('item'));
    }

    // Delete user by id
    public function delete($id) {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $api->delete('AUTH_SERVICE', '/account/delete/' . urlencode($id));
        return $this->redirect('/users');
    }
}
