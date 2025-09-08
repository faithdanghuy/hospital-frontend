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
        echo '<pre>'; print_r($items); echo '</pre>';
        return $this->view('notifications/index', compact('items'));
    }

    // Mark as read
    public function markAsRead($id){
        $this->requireCsrf();
        $api = new ApiClient($this->config);
        $res = $api->post('NOTIFICATION_SERVICE', '/notify/mark-read/' . urlencode($id), ["is_read" => true]);
        return $this->redirect('/notification');
    }
}
