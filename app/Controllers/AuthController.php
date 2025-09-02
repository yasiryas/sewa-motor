<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function index()
    {
        //
    }

    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function loginProcess()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // validation
        if (!$email || !$password) {
            return redirect()->back()->with('error', 'Ups! Data harus lengkap');
        }

        // check user
        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan');
        }

        // verify password
        if (!password_verify($password, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Password salah');
            // dd($user['password'], $password, password_hash($password, PASSWORD_BCRYPT));
        }

        // set session
        session()->set([
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role'],
            'logged_in' => true,
        ]);
        // dd(session()->get());

        return redirect()->to('motors');
    }

    public function registerProcess()
    {
        $name = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // validation
        if (!$name || !$email || !$password || !$confirmPassword) {
            return redirect()->back()->with('error', 'Ups! Data harus lengkap');
        }

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Password dan konfirmasi password tidak sesuai');
        }

        // check if email already exists
        $userModel = new \App\Models\UserModel();
        $existingUser = $userModel->where('email', $email)->first();

        if ($existingUser) {
            return redirect()->back()->with('error', 'Email sudah terdaftar');
        }

        // insert user
        $userModel->insert([
            'username' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'role' => 'user',
        ]);

        return redirect()->to('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }
}
