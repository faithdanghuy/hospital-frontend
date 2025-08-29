<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Services\ApiClient;

class NotificationController extends Controller {
    // Get all notifications
    public function index() {
        $api = new ApiClient($this->config);
        $res = $api->get('NOTIFICATION_SERVICE', '/notify/notification');
        $items = $res['data']['data'] ?? [];
        return $this->view('notifications/index', compact('items'));
    }

    // // Open create notification form
    // public function create() {
    //     if ($this->isPost()) {
    //         $this->requireCsrf();
    //         $api = new ApiClient($this->config);
    //         $payload = $_POST;
    //         unset($payload['_csrf']);
    //         $res = $api->post('NOTIFICATION_SERVICE', '/notification', $payload);
    //         if (($res['status'] ?? 500) < 300) return $this->redirect('/notifications');
    //         $error = $res['data']['message'] ?? 'Create failed';
    //         return $this->view('notifications/create', compact('error'));
    //     }
    //     return $this->view('notifications/create');
    // }

    // Mark as read
    public function markAsRead($id){
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $res = $api->post('NOTIFICATION_SERVICE', '/notification/' . urlencode($id), ['read' => true]);
        return $this->redirect('/notifications');
    }

    // public function edit($id) {
    //     $api = new ApiClient($this->config);
    //     if ($this->isPost()) {
    //         $this->requireCsrf();
    //         $payload = $_POST; unset($payload['_csrf']);
    //         $res = $api->put('NOTIFICATION_SERVICE', '/notifications/' . urlencode($id), $payload);
    //         if (($res['status'] ?? 500) < 300) return $this->redirect('/notifications');
    //         $error = $res['data']['message'] ?? 'Update failed';
    //         $item = $payload;
    //         return $this->view('notifications/edit', compact('item','error'));
    //     }
    //     $res = $api->get('NOTIFICATION_SERVICE', '/notifications/' . urlencode($id));
    //     $item = $res['data'] ?? [];
    //     return $this->view('notifications/edit', compact('item'));
    // }
    
    // Delete a notification by id
    public function delete($id) {
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $api->delete('NOTIFICATION_SERVICE', '/notification/delete/' . urlencode($id));
        return $this->redirect('/notifications');
    }
}
