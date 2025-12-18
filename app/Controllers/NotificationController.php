<?php

namespace App\Controllers;

use App\Models\UserDeviceModel;
use App\Models\NotificationModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;


class NotificationController extends BaseController
{
    protected $notificationModel;
    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    public function index()
    {
        //
    }

    public function latest()
    {
        // 🔒 proteksi admin
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return $this->response->setStatusCode(403);
        }

        $model = new NotificationModel();

        $notifications = $model
            ->where('user_id', session()->get('id'))
            ->where('is_read', 0)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->findAll();

        return $this->response->setJSON(
            array_map(function ($n) {
                return [
                    'title' => $n['title'],
                    'time'  => time_elapsed_string($n['created_at']),
                    'link'  => $n['link']
                ];
            }, $notifications)
        );
    }

    public function saveFcmToken()
    {
        $data = $this->request->getJSON(true);

        if (!$data || !isset($data['token'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'message' => 'Token tidak valid'
            ]);
        }

        $userId = session()->get('id');

        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $deviceModel = new UserDeviceModel();

        // Cegah token dobel
        $exists = $deviceModel
            ->where('user_id', $userId)
            ->where('fcm_token', $data['token'])
            ->first();

        if (!$exists) {
            $deviceModel->insert([
                'user_id'   => $userId,
                'fcm_token' => $data['token'],
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'FCM token saved'
        ]);
    }

    public function markRead()
    {
        $this->notificationModel = new NotificationModel();

        $userId = session()->get('id');

        $this->notificationModel
            ->where('user_id', $userId)
            ->where('is_read', 0)
            ->set(['is_read' => 1])
            ->update();

        return $this->response->setJSON(['status' => 'ok']);
    }
}
