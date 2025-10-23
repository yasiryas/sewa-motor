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

    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Display login page
     *
     * @return mixed
     */
    /*******  cc778546-b54b-4a72-ba71-d419b160c522  *******/
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
        return redirect()->to('login')->with('success', 'Ups, Anda telah logout.');
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
            'isLoggedIn' => true,
        ]);
        // dd(session()->get());
        $redirectUrl = session()->get('redirect_url');
        if ($redirectUrl) {
            session()->remove('redirect_url');
            return redirect()->to($redirectUrl);
        }

        if (session()->get('role') == 'admin') {
            return redirect()->to('dashboard/index');
        } else {
            return redirect()->to('/');
        }
    }

    public function registerProcess()
    {
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // validation
        if (!$username || !$email || !$password || !$confirmPassword) {
            return redirect()->back()->with('error', 'Ups! Data harus lengkap');
        }

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Password dan konfirmasi password tidak sesuai');
        }

        // check if email already exists
        $userModel = new \App\Models\UserModel();
        $existingEmail = $userModel->where('email', $email)->first();
        $existingUsername = $userModel->where('username', $username)->first();

        if ($existingEmail) {
            return redirect()->back()->with('error', 'Email sudah terdaftar');
        } else if ($existingUsername) {
            return redirect()->back()->with('error', 'Username sudah terdaftar');
        }

        // insert user
        $userModel->insert([
            'username' => $username,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'role' => 'user',
        ]);

        return redirect()->to('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }
}
