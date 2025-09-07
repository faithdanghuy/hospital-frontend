<?php
namespace App\Services;

use App\Core\Auth;

class ApiClient {
    private array $config;

    public function __construct(array $config) {
        $this->config = $config;
    }

    private function request(string $method, string $url, ?array $data = null) {
        $ch = curl_init();
        $headers = ['Accept: application/json'];

        if ($token = Auth::token()) {
            $headers[] = 'Authorization: Bearer ' . $token;
        }
        if ($data !== null) {
            $headers[] = 'Content-Type: application/json';
        }

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        if ($data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $res = curl_exec($ch);
        if ($res === false) {
            return ['error' => curl_error($ch)];
        }

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $json = json_decode($res, true);
        return ['status' => $status, 'data' => $json];
    }

    public function get(string $service, string $path, array $params = []) {
        $url = $this->config[$service] . $path;
    
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
    
        return $this->request('GET', $url);
    }

    public function post(string $service, string $path, array $data) {
        return $this->request('POST', $this->config[$service] . $path, $data);
    }

    public function patch(string $service, string $path, array $data) {
        return $this->request('PATCH', $this->config[$service] . $path, $data);
    }

    public function put(string $service, string $path, array $data) {
        return $this->request('PUT', $this->config[$service] . $path, $data);
    }

    public function delete(string $service, string $path) {
        return $this->request('DELETE', $this->config[$service] . $path);
    }
}
