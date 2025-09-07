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

    // Mark as read
    public function markAsRead($id){
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $res = $api->post('NOTIFICATION_SERVICE', '/notify/mark-read/' . urlencode($id), []);
        return $this->redirect('/notifications');
    }
    
    // // Delete a notification by id
    // public function delete($id) {
    //     $this->requireCsrf();
    //     $api = new ApiClient($this->config);
    //     $api->delete('NOTIFICATION_SERVICE', '/notification/delete/' . urlencode($id));
    //     return $this->redirect('/notifications');
    // }
}
