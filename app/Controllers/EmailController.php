<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class EmailController extends BaseController
{
    public function index()
    {
        //
    }

    public function sendEmail()
    {
        $emailUser = $this->request->getPost('email');
        $messageUser = $this->request->getPost('pesan');
        $whatsappUser = $this->request->getPost('whatsapp');

        if (!$emailUser || !$messageUser || !$whatsappUser) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => 'false',
                    'message' => 'Upss! Semua harus diisi.'
                ]);
            }
            return redirect()->back()->withInput()->with('error', 'Upss! Semua harus diisi.');
        }

        $email = \Config\Services::email();

        $email->setFrom('sewaskuterjogja.com@gmail.com', 'Sewa Skuter Jogja');
        $email->setTo('yasir123983@gmail.com');
        $email->setSubject('Email From Client Website Sewa Skuter Jogja');
        $email->setMessage("<h3>Pesan Baru dari Website</h3>
            <p><strong>Email Pengirim:</strong> {$emailUser}</p>
            <p><strong>Nomor WhatsApp:</strong> {$whatsappUser}</p>
            <p><strong>Pesan:</strong><br>{$messageUser}</p>");

        if ($email->send()) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => 'true',
                    'message' => 'Terima kasih! Pesan Anda telah terkirim.'
                ]);
            }
            session()->setFlashdata('success', 'Terima kasih! Pesan Anda telah terkirim.');
            return redirect()->back();
        } else {
            $errorMessaage = $email->printDebugger(['headers']);
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => 'false',
                    'message' => 'Maaf, terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti. ' . $errorMessaage
                ]);
            }
            return redirect()->back()->withInput()->with('error', 'Maaf, terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti. ' . $errorMessaage);
        }
    }
}
