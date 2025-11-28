<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SettingController extends BaseController
{
    protected $FaqModel;
    public function __construct()
    {
        $this->FaqModel = new \App\Models\FaqModel();
    }
    public function indexFAQ()
    {
        $faqs = $this->FaqModel->findAll();
        $data = [
            'title' => 'Settings',
            'submenu_title' => 'FAQ Setting',
            'faqs' => $faqs,
        ];
        return view('dashboard/settings/faq', $data);
    }
    public function faq()
    {
        $question = $this->request->getPost('question');
        $answer = $this->request->getPost('answer');

        $data = [
            'question' => $question,
            'answer' => $answer,
        ];

        $this->FaqModel->insert($data);
        session()->setFlashdata('success', 'FAQ added successfully.');
        if ($this->request->isAjax()) {
            return $this->response->setJSON(['success' => true]);
        }
        return redirect()->back();
    }

    public function faqStore()
    {
        $question = $this->request->getPost('question');
        $answer = $this->request->getPost('answer');

        $data = [
            'question' => $question,
            'answer' => $answer,
        ];

        $this->FaqModel->insert($data);
        session()->setFlashdata('success', 'FAQ added successfully.');
        if ($this->request->isAjax()) {
            return $this->response->setJSON(['success' => true]);
        }
        return redirect()->back();
    }

    public function faqUpdate()
    {
        $id = $this->request->getPost('id');
        $question = $this->request->getPost('question');
        $answer = $this->request->getPost('answer');

        $data = [
            'question' => $question,
            'answer' => $answer,
        ];

        $this->FaqModel->update($id, $data);
        session()->setFlashdata('success', 'FAQ updated successfully.');
        if ($this->request->isAjax()) {
            return $this->response->setJSON(['success' => true]);
        }
        return redirect()->back();
    }

    public function faqDelete()
    {
        $id = $this->request->getPost('id');
        $this->FaqModel->delete($id);
        session()->setFlashdata('success', 'FAQ deleted successfully.');
        if ($this->request->isAjax()) {
            return $this->response->setJSON(['success' => true]);
        }
        return redirect()->back();
    }

    public function profile()
    {
        $userModel = new UserModel();
        $data = [
            'title' => 'Settings',
            'submenu_title' => 'Profile',
            'user' => $userModel->find(session()->get('id'))
        ];
        return view('dashboard/settings/profile', $data);
    }

    public function updateProfile()
    {
        $validationRules = [
            'full_name' => [
                'label' => 'Full Name',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'max_length' => '{field} tidak boleh lebih dari 100 karakter    .'
                ]
            ],
            'phone' => [
                'label' => 'Phone Number',
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'min_length' => '{field} minimal 10 karakter.'
                ]
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $id = session()->get('id');
        $full_name = $this->request->getPost('full_name');
        $phone = $this->request->getPost('phone');

        $data = [
            'full_name' => $full_name,
            'phone' => $phone,
        ];

        $userModel->update($id, $data);
        session()->setFlashdata('success', 'Profile updated successfully.');
        return redirect()->back();
    }

    public function updatePassword()
    {
        $userModel = new UserModel();
        $id = session()->get('id');
        $current_password = $this->request->getPost('current_password');
        $new_password = $this->request->getPost('new_password');
        $confirm_new_password = $this->request->getPost('confirm_new_password');
        $user = $userModel->find($id);

        $validationRules = [
            'current_password' => [
                'label' => 'Current Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'new_password' => [
                'label' => 'New Password',
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'min_length' => '{field} minimal 6 karakter.'
                ]
            ],
            'confirm_new_password' => [
                'label' => 'Confirm New Password',
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'matches' => '{field} tidak sesuai dengan Password Baru.'
                ]
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if (!password_verify($current_password, $user['password_hash'])) {
            session()->setFlashdata('error_current_password', 'Password lama tidak sesuai.');
            return redirect()->back();
        }

        if ($new_password !== $confirm_new_password) {
            session()->setFlashdata('error_new_password', 'Password baru dan konfirmasi tidak sesuai.');
            return redirect()->back();
        }

        $data = [
            'password_hash' => password_hash($new_password, PASSWORD_DEFAULT),
        ];

        $userModel->update($id, $data);

        session()->setFlashdata('success', 'Password updated successfully.');
        return redirect()->back();
    }

    public function profileBussiness()
    {
        $userModel = new UserModel();
        $data = [
            'title' => 'Settings',
            'submenu_title' => 'Profile Bussiness',
            'user' => $userModel->find(session()->get('id'))
        ];
        return view('dashboard/settings/profile_bussiness', $data);
    }
}
