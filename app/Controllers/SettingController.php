<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SettingController extends BaseController
{
    protected $FaqModel;
    public function __construct()
    {
        $this->FaqModel = new \App\Models\FaqModel();
    }
    public function index()
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
}
