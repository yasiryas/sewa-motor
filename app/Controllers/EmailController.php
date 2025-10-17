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
        $email = \Config\Services::email();

        $email->setFrom('sewaskuterjogja.com@gmail.com', 'Sewa Skuter Jogja');
        $email->setTo('yasir123983@gmail.com');
        $email->setSubject('Test Email from CodeIgniter');
        $email->setMessage('This is a test email sent from CodeIgniter application.');

        if ($email->send()) {
            return $this->response->setStatusCode(200)->setBody('Email sent successfully.');
        } else {
            $data = $email->printDebugger(['headers']);
            return $this->response->setStatusCode(500)->setBody('Failed to send email. ' . $data);
        }
    }
}
