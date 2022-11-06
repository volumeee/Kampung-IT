<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('username', 'Username / Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = ' Login';
            $data['identitas'] = $this->db->get('identitas')->row_array();
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // validasi success, dibuat privat agar hanya bisa diakses oleh class ini saja || tidak bisa diakses url
            $this->_login();
        }
    }

    private function _login()
    {
        $usernameOrEmail = $this->input->post('username');
        $password = $this->input->post('password');
        // cek dulu yg di input imel atau username
        if (!filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            // username
            $user = $this->db->get_where('user', ['username' => $usernameOrEmail])->row_array();
        } else {
            // imel
            $user = $this->db->get_where('user', ['email' => $usernameOrEmail])->row_array();
        }
        // kalo ada usernya
        if ($user) {
            // jika usernya aktif
            if ($user['is_active'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {
                    // buat data untuk session
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    // update aktivitas login user
                    $this->db->set('last_login', time());
                    $this->db->where('email', $data['email']);
                    $this->db->update('user');
                    // arahkan sesuai halaman defaultnya
                    switch ($user['role_id']) {
                        case '1':
                            redirect('admin');
                            break;
                        case '2':
                            redirect('merchant/chat');
                            break;
                        case '3':
                            redirect('member');
                            break;
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password tidak cocok.</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun belum diaktivasi.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email tidak terdaftar.</div>');
            redirect('auth');
        }
    }

    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        // set form validation
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email ini sudah terdaftar.'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[8]|matches[password2]', [
            'matches' => 'Pengulangan password tidak sama.',
            'min_length' => 'Password terlalu pendek, min. 8 karakter'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Kampung IT Resgistrasi Akun';
            $data['identitas'] = $this->db->get('identitas')->row_array();
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 3,
                'is_active' => 0,
                'date_created' => time()
            ];
            // siapkan token
            $token = rand(1000, 9999);
            $user_token = [
                'token' => $token,
                'date_created' => time()
            ];
            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);
            // panggil method sendemail
            $this->_sendEmail($token, 'verify');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil membuat akun. Masukkan kode yang sudah dikirim ke email untuk aktivasi akun!</div>');
            redirect('auth/verify');
        }
    }

    private function _sendEmail($token, $type)
    {
        $email = $this->input->post('email');
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_user' => 'kampungit.offc@gmail.com',
            'smtp_pass' => 'unmjwvjwzseknbtl',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];
        // panggi library
        $this->load->library('email', $config);
        $this->email->initialize($config);
        // cek type kirim email
        if ($type == 'verify') {
            $this->email->from('kampungit.offc@gmail.com', 'Kampung IT Aktivasi Akun - ' . $token);
            $this->email->to($email);
            $this->email->subject('Account Verification');
            $this->email->message('Masukkan kode di bawah ini untuk melakukan aktivasi akun Anda, kode hanya berlaku satu jam setelah diterbitkan. Apabila Anda tidak melakukan aktivitas ini, maka abaikan E-mail ini.<left><h1>' . $token . '</h1>©2022 Kampung IT One-Time Code</left>');
            $this->session->set_userdata('verify_email', $email);
        } else if ($type == 'forgot') {
            $this->email->from('kampungit.offc@gmail.com', 'Kampung IT Lupa Password - ' . $token);
            $this->email->to($email);
            $this->email->subject('Reset Password');
            $this->email->message('Masukkan kode di bawah ini untuk melakukan reset password akun Anda, kode hanya berlaku satu jam setelah diterbitkan. Apabila Anda tidak melakukan aktivitas ini, maka abaikan E-mail ini.<left><h1>' . $token . '</h1>©Kampung IT One-Time Code</left>');
            $this->session->set_userdata('forgot_password', $email);
        }
        // jika terjadi error saat kirim
        if ($this->email->send()) {
            return true;
        } else {
            // echo $this->email->print_debugger();
            echo '<p>Gagal mengirim email, masukkan kode berikut</p>';
            echo '<h4>' . $token . '</h4>';
            echo '<a href="' . base_url('auth/verify') . '">Klik di sini untuk melanjutkan aktifasi akun</a>';
            die;
        }
    }

    public function verify()
    {
        $data['email'] = $this->session->userdata('verify_email');
        $this->form_validation->set_rules('token', 'Token', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Kampung IT User Verify';
            $data['identitas'] = $this->db->get('identitas')->row_array();
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/verify');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $token = $this->input->post('token');
            $user = $this->db->get_where('user', ['email' => $email])->row_array();
            if ($user) {
                $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

                if ($user_token) {
                    if (time() - $user_token['date_created'] < (60 * 60 * 1)) {
                        $this->db->set('is_active', 1);
                        $this->db->where('email', $email);
                        $this->db->update('user');
                        $this->db->delete('user_token', ['token' => $token]);
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' sudah aktif, silakan login.</div>');
                        redirect('auth');
                    } else {
                        $this->db->delete('user', ['email' => $email]);
                        $this->db->delete('user_token', ['token' => $token]);
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktivasi akun gagal! kode token sudah expired.</div>');
                        redirect('auth/verify');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktivasi akun gagal! kode token tidak cocok.</div>');
                    redirect('auth/verify');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktivasi akun gagal! E-mail tidak cocok.</div>');
                redirect('auth/verify');
            }
        }
    }


    public function logout()
    {
        // update aktivitas user
        $this->db->set('last_login', time());
        $this->db->where('email', $this->session->userdata('email'));
        $this->db->update('user');
        // unset
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil logout.</div>');
        redirect('auth');
    }

    public function blocked()
    {
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $this->load->view('auth/blocked', $data);
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $data['identitas'] = $this->db->get('identitas')->row_array();
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();
            // jika usernya ada
            if ($user) {
                $token = rand(1000, 9999);
                $user_token = [
                    'token' => $token,
                    'date_created' => time()
                ];
                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Masukkan kode yang sudah dikirim ke email untuk reset password akun.</div>');
                redirect('auth/resetpassword');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">E-mail Anda tidak terdaftar atau bisa jadi belum aktif.</div>');
                redirect('auth/resetpassword');
            }
        }
    }

    public function resetPassword()
    {
        $this->form_validation->set_rules('token', 'Token', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Kampung IT Reset Password';
            $data['identitas'] = $this->db->get('identitas')->row_array();
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/reset-password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $token = $this->input->post('token');
            // jadikan emailnya session untuk ditampilkan di form
            $this->session->set_userdata('forgot_password', $email);
            $user = $this->db->get_where('user', ['email' => $email])->row_array();
            // jika usernya ada
            if ($user) {
                $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

                if ($user_token) {
                    $this->session->set_userdata('reset_email', $email);
                    $this->session->set_userdata('reset_token', $token);
                    $this->changePassword();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password gagal! token tidak cocok.</div>');
                    redirect('auth/resetpassword');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password gagal! E-mail tidak cocok.</div>');
                redirect('auth/resetpassword');
            }
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }
        // set form validation
        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[8]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[8]|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Kampung IT Change Password';
            $data['identitas'] = $this->db->get('identitas')->row_array();
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');
            $token = $this->session->userdata('reset_token');
            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');
            // hilangan session reset email ygg tadi dibuat
            $this->session->unset_userdata('reset_email');
            // hapus token dari db
            $this->db->delete('user_token', ['token' => $token]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil reset password, silakan login.</div>');
            redirect('auth');
        }
    }
}
