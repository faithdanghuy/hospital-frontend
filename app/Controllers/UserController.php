<?php
namespace App\Controllers;
use App\Core\Controller;
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
            return $this->redirect('users/create');
        }

        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $payload = $_POST;
        unset($payload['_csrf']);
        $res = $api->post('AUTH_SERVICE', '/auth/register', $payload);
            
        if (($res['status'] ?? 500) < 300) {
            return $this->redirect('/account');
        }
        $error = $res['data']['message'] ?? 'Create user failed';
        $old = $payload;
        return $this->view('users/create', compact('error', 'old'));
    }

    // Open current user edit form
    public function edit() {
        $api = new ApiClient($this->config);
        $res = $api->get('AUTH_SERVICE', '/account/profile');
        $item = $res['data']['data'] ?? [];
        return $this->view('users/edit-self', compact('item'));
    }

    // Open other user edit form
    public function editUser($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('AUTH_SERVICE', '/account/detail/' . urlencode($id));
        $item = $res['data']['data'] ?? [];
        return $this->view('users/edit-user', compact('item', 'id'));
    }

    // Update current user profile
    public function update() {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $payload = $_POST;
        unset($payload['_csrf']);
        $res = $api->patch('AUTH_SERVICE', '/account/update', $payload);

        if (($res['status'] ?? 500) < 300) {
            return $this->redirect('/account/profile');
        }
        $error = $res['data']['message'] ?? 'Update profile failed';
        $old = $payload;
        return $this->view('users/edit-self', compact('error', 'old'));
    }

    // Update other user profile
    public function updateUser($id) {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $payload = $_POST;
        unset($payload['_csrf']);
        $res = $api->patch('AUTH_SERVICE', '/account/edit/' . urlencode($id), $payload);

        if (($res['status'] ?? 500) < 300) {
            return $this->redirect('/account/detail/' . urlencode($id));
        }
        $error = $res['data']['message'] ?? 'Update user failed';
        $old = $payload;
        return $this->view('users/edit-user', compact('error', 'old', 'id'));
    }

    // Open current user profile
    public function myProfile() {
        $api = new ApiClient($this->config);
        $res = $api->get('AUTH_SERVICE', '/account/profile');
        // echo '<pre>';
        // var_dump($res);
        // echo '</pre>';
        // exit;
        $item = $res['data']['data'] ?? $res ?? [];
        return $this->view('users/show-self', ['item' => $item]);
    }
    
    // Open user detail by id
    public function show($id) {
        $api = new ApiClient($this->config);
        $res = $api->get('AUTH_SERVICE', '/account/detail/' . urlencode($id));
        $item = $res['data']['data'] ?? [];
        return $this->view('users/show-user', compact('item'));
    }

    // Delete user by id
    public function delete($id) {
        $this->requireCsrf();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_method'] ?? '') === 'DELETE') {
            $api = new ApiClient($this->config);
            $api->delete('AUTH_SERVICE', '/account/delete/' . urlencode($id));
            return $this->redirect('/account');
        }
    }
}
