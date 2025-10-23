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
            return $this->response->setStatusCode(400)->setBody('Upss! Semua harus diisi.');
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
            // return $this->response->setStatusCode(200)->setBody('Email sent successfully.');
            session()->setFlashdata('success', 'Pesan Anda telah terkirim. Kami akan menghubungi Anda segera.');
            return redirect()->back();
        } else {
            // $data = $email->printDebugger(['headers']);
            // return $this->response->setStatusCode(500)->setBody('Failed to send email. ' . $data);
            session()->setFlashdata('error', 'Maaf, terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti.');
            return redirect()->back();
        }
    }
}
