<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $userModel;
    protected $bookingModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->userModel = new \App\Models\UserModel();
        $this->bookingModel = new \App\Models\BookingModel();
    }

    public function index() {}
    public function dashboard()
    {
        if (!session()->get('id')) {
            return redirect()->to('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak.');
        }

        $userModel = new \App\Models\UserModel();
        $data = [
            'title' => 'Users',
            'submenu_title' => 'Penyewa',
            'user' => $userModel->find(session()->get('id')),
            'users' => $userModel->where('role', 'user')->findAll(),
        ];
        return view('dashboard/users', $data);
    }

    public function reportUsers()
    {
        if (!session()->get('id')) {
            return redirect()->to('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak.');
        }
        $data['users'] = $this->userModel->where('role', 'customer')->findAll();
        $data['title'] = 'Report';
        $data['submenu_title'] = 'Report Users';
        return view('dashboard/user-report', $data);
    }

    public function store()
    {
        // Validasi input
        $validationRules = [
            'username' => [
                'rules' => 'required|is_unique[users.username]|min_length[3]|max_length[20]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'is_unique' => 'Username sudah digunakan.',
                    'min_length' => 'Username minimal 3 karakter.',
                    'max_length' => 'Username maksimal 20 karakter.',
                ]
            ],
            'full_name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama lengkap minimal 3 karakter.',
                    'max_length' => 'Nama lengkap maksimal 100 karakter.',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email sudah digunakan.',
                ]
            ],
            'phone' => [
                'rules' => 'required|min_length[10]|max_length[15]',
                'errors' => [
                    'required' => 'Nomor telepon wajib diisi.',
                    'min_length' => 'Nomor telepon minimal 10 digit.',
                    'max_length' => 'Nomor telepon maksimal 15 digit.',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.',
                ]
            ],
            'repeat_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Ulangi Password wajib diisi.',
                    'matches' => 'Ulangi Password belum cocok.',
                ]
            ],
            'role' => [
                'rules' => 'required|in_list[admin,user, owner]',
                'errors' => [
                    'required' => 'Role wajib diisi.',
                    'in_list' => 'Role tidak valid.',
                ],
            ]
        ];
        if (!$this->validate($validationRules)) {
            return redirect()->to('dashboard/users')->withInput()->with('error', $this->validator->listErrors())->with('modal', 'addUserModal');
        }


        $userModel = new \App\Models\UserModel();
        $userModel->save([
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role' => $this->request->getPost('role'),
        ]);
        return redirect()->to('dashboard/users')->with('success', 'User berhasil ditambahkan.');
    }

    public function delete()
    {
        $id = $this->request->getPost('user_id_delete');
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('dashboard/users')->with('error', 'User tidak ditemukan.');
        }

        $this->userModel->delete($id);
        return redirect()->to('dashboard/users')->with('success', 'User berhasil dihapus.');
    }

    public function resetPassword()
    {
        $id = $this->request->getPost('id_reset_password_user');
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('dashboard/users')->with('error', 'User tidak ditemukan.');
        }

        // Validasi input
        $validationRules = [
            'password_reset' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.',
                ]
            ],
            'repeat_password_reset' => [
                'rules' => 'required|matches[password_reset]',
                'errors' => [
                    'required' => 'Ulangi Password wajib diisi.',
                    'matches' => 'Ulangi Password belum cocok.',
                ]
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->to('dashboard/users')->withInput()->with('error', $this->validator->listErrors())->with('modal', 'resetPasswordUserModal')->with('id_reset_password_user', $id);
        }

        $this->userModel->update($id, [
            'password_hash' => password_hash($this->request->getPost('password_reset'), PASSWORD_BCRYPT),
        ]);

        return redirect()->to('dashboard/users')->with('success', 'Password user berhasil direset.');
    }

    public function search()
    {
        $keyword = $this->request->getGet('q');

        $users = $this->userModel
            ->like('username', $keyword)
            ->orLike('email', $keyword)
            ->findAll(10);

        // hanya return field penting
        $result = array_map(function ($user) {
            return [
                'id'       => $user['id'],
                'username' => $user['username'],
                'email'    => $user['email'],
            ];
        }, $users);

        return $this->response->setJSON($result);
    }

    public function storeUserInBooking()
    {
        // Validasi input
        $validationRules = [
            'username' => [
                'rules' => 'required|is_unique[users.username]|min_length[3]|max_length[20]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'is_unique' => 'Username sudah digunakan.',
                    'min_length' => 'Username minimal 3 karakter.',
                    'max_length' => 'Username maksimal 20 karakter.',
                ]
            ],
            'full_name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama lengkap minimal 3 karakter.',
                    'max_length' => 'Nama lengkap maksimal 100 karakter.',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email sudah digunakan.',
                ]
            ],
            'phone' => [
                'rules' => 'required|min_length[10]|max_length[15]',
                'errors' => [
                    'required' => 'Nomor telepon wajib diisi.',
                    'min_length' => 'Nomor telepon minimal 10 digit.',
                    'max_length' => 'Nomor telepon maksimal 15 digit.',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.',
                ]
            ],
            'repeat_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Ulangi Password wajib diisi.',
                    'matches' => 'Ulangi Password belum cocok.',
                ]
            ],
            'role' => [
                'rules' => 'required|in_list[admin,user, owner]',
                'errors' => [
                    'required' => 'Role wajib diisi.',
                    'in_list' => 'Role tidak valid.',
                ],
            ]
        ];
        if (!$this->validate($validationRules)) {
            return redirect()->to('dashboard/users')->withInput()->with('error', $this->validator->listErrors())->with('modal', 'addUserModal');
        }


        $userModel = new \App\Models\UserModel();
        $userModel->save([
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role' => $this->request->getPost('role'),
        ]);
        return redirect()->to('dashboard/booking')->with('success', 'User berhasil ditambahkan.')->with('modal', 'addBookingModal');
    }

    public function profile()
    {
        if (!session()->get('id')) {
            return redirect()->to('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $lastBooking = $this->bookingModel
            ->select('
            bookings.*,
            motors.name AS motor_name,
            motors.number_plate,
            motors.price_per_day,
            brands.brand AS brand_name,
            types.type AS type_name
        ')
            ->join('motors', 'motors.id = bookings.motor_id', 'left')
            ->join('brands', 'brands.id = motors.id_brand', 'left')
            ->join('types', 'types.id = motors.id_type', 'left')
            ->where('bookings.user_id', session()->get('id'))
            ->orderBy('bookings.created_at', 'DESC')
            ->limit(5)
            ->findAll();

        $user = $this->userModel->find(session()->get('id'));

        $data = [
            'title'      => 'Profile',
            'user'       => $user,
            'activities' => $lastBooking
        ];

        return view('frontend/profile', $data);
    }


    public function updateProfile()
    {
        $id = session()->get('id');
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('profile')->with('error', 'User tidak ditemukan.');
        }

        // Validasi input
        $validationRules = [
            'full_name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama lengkap minimal 3 karakter.',
                    'max_length' => 'Nama lengkap maksimal 100 karakter.',
                ]
            ],
            'phone' => [
                'rules' => 'required|min_length[10]|max_length[15]',
                'errors' => [
                    'required' => 'Nomor telepon wajib diisi.',
                    'min_length' => 'Nomor telepon minimal 10 digit.',
                    'max_length' => 'Nomor telepon maksimal 15 digit.',
                ]
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->to('profile')->withInput()->with('error', $this->validator->listErrors());
        }

        $this->userModel->update($id, [
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
        ]);

        return redirect()->to('profile')->with('success', 'Profile berhasil diperbarui.');
    }

    public function changePassword()
    {
        if (!session()->get('id')) {
            return redirect()->to('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $id = session()->get('id');
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('profile')->with('error', 'User tidak ditemukan.');
        }

        // Validasi input
        $validationRules = [
            'current_password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password saat ini wajib diisi.',
                ]
            ],
            'new_password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password baru wajib diisi.',
                    'min_length' => 'Password baru minimal 6 karakter.',
                ]
            ],
            'confirm_new_password' => [
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Ulangi Password baru wajib diisi.',
                    'matches' => 'Ulangi Password baru belum cocok.',
                ]
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->to('profile')->withInput()->with('error', $this->validator->listErrors());
        }

        // Cek password saat ini
        if (!password_verify($this->request->getPost('current_password'), $user['password_hash'])) {
            return redirect()->to('profile')->withInput()->with('error', 'Password saat ini salah.');
        }

        // Update password
        $this->userModel->update($id, [
            'password_hash' => password_hash($this->request->getPost('new_password'), PASSWORD_BCRYPT),
        ]);

        return redirect()->to('profile')->with('success', 'Password berhasil diubah.');
    }
}
