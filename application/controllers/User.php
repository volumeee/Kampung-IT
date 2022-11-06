<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('User_model', 'user');
        $data['kategori'] = $this->db->get('kategori')->result_array();
        $data['merchant'] = $this->db->get_where('merchant', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        if ($this->input->post('username') != trim($this->input->post('usernameNew'))) $this->form_validation->set_rules('usernameNew', 'Username', 'required|trim|is_unique[user.username]', [
            'is_unique' => 'Username sudah terdaftar.'
        ]);
        $this->form_validation->set_rules('name', 'Full name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $email = htmlspecialchars($this->input->post('email'), true);
            $status = htmlspecialchars(base64_decode($this->input->post('status')), true);

            if ($status == 'delete') {
                $old_image = $this->input->post('image');
                $email = $this->input->post('email');
                $image = 'default.jpg';

                unlink(FCPATH . 'assets/img/profile/' . $old_image);

                $this->db->set('image', $image);
                $this->db->where('email', $email);
                $this->db->update('user');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile picture has been deleted.</div>');
                redirect('user');
            } else {
                $email = trim(htmlspecialchars($this->input->post('email'), true));
                $name = trim(htmlspecialchars($this->input->post('name'), true));
                $username = trim(htmlspecialchars($this->input->post('usernameNew'), true));
                $alamat = trim(htmlspecialchars($this->input->post('alamat'), true));
                $no_telp = trim(htmlspecialchars($this->input->post('no_telp'), true));

                //cek jika ada gambar yang diupload
                $upload_image = $_FILES['image']['name'];

                if ($upload_image) {
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
                    $config['max_size']     = '8192';
                    $config['upload_path'] = './assets/img/profile/';

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('image')) {
                        $old_image = $data['user']['image'];
                        if ($old_image != 'default.jpg') {
                            unlink(FCPATH . 'assets/img/profile/' . $old_image);
                        }
                        $new_image = $this->upload->data('file_name');
                        $this->db->set('image', $new_image);
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops! Sorry, can not change image profile. Your file type is not supported or your file is too large file size.</div>');
                        redirect('user');
                    }
                }

                $this->db->set(['name' => $name, 'username' => $username, 'alamat' => $alamat, 'no_telp' => $no_telp]);
                $this->db->where('email', $email);
                $this->db->update('user');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile has been updated.</div>');
                redirect('user/edit');
            }
        }
    }

    public function changePassword()
    {
        $data['title'] = 'Change Password';
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password.</div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password.</div>');
                    redirect('user/changepassword');
                } else {
                    // password ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password changed.</div>');
                    redirect('user/changepassword');
                }
            }
        }
    }

    public function openMerchant()
    {
        $this->load->model('Admin_model', 'admin');
        $nama_usaha = htmlspecialchars($this->input->post('nama_usaha'));
        $email = $this->session->userdata('email');
        $kategori = htmlspecialchars($this->input->post('kategori'));
        $alamat = htmlspecialchars($this->input->post('alamat'));
        $deskripsi = htmlspecialchars($this->input->post('deskripsi'));
        if ($this->db->insert('merchant', [
            'merchant_id' => $this->admin->autoId('merchant', 'merchant_id', 'MRC'),
            'nama_usaha' => $nama_usaha,
            'email' => $email,
            'kategori' => $kategori,
            'alamat' => $alamat,
            'deskripsi' => $deskripsi,
            'is_active' => 0
        ])) {
            // siapkan token
            $token = rand(1000, 9999);
            $user_token = [
                'token' => $token,
                'date_created' => time()
            ];
            $this->db->insert('user_token', $user_token);
            // panggil method sendemail
            $this->_sendEmail($token, $nama_usaha, $email);
        } else $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Opps! Mohon maaf, gagal disimpan silakan untuk mencoba lagi.</div>');
        redirect('user');
    }

    public function resendCodeMerchant()
    {
        $email = $this->input->post('email');
        $nama_usaha = $this->input->post('nama_usaha');
        // siapkan token
        $token = rand(1000, 9999);
        $user_token = [
            'token' => $token,
            'date_created' => time()
        ];
        $this->db->insert('user_token', $user_token);
        // panggil method sendemail
        $this->_sendEmail($token, $nama_usaha, $email);
        // redirect user
        redirect('user');
    }

    private function _sendEmail($token, $nama_usaha, $email)
    {
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
        // kirim email
        $this->email->from('kampungit.offc@gmail.com', 'Kampung IT Aktivasi Merchant - ' . $token);
        $this->email->to($email);
        $this->email->subject('Merchant Verification');
        $this->email->message('Masukkan kode di bawah ini untuk melakukan aktivasi sebagai penyedia jasa dengan nama usaha <strong>' . $nama_usaha . '</strong>, kode hanya berlaku satu jam setelah diterbitkan. Apabila Anda tidak melakukan aktivitas ini, maka abaikan E-mail ini.<left><h1>' . $token . '</h1>©2022 Kampung IT One-Time Code</left>');
        // jika terjadi error saat kirim
        if ($this->email->send()) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Silakan buka email <strong>**' . substr($email, 2, 12) . '**</strong> yang berisi kode untuk aktivasi merchant, terima kasih.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Opps! Mohon maaf, gagal disimpan silakan untuk mencoba lagi.</div>');
        }
    }

    public function aktivateMerchant()
    {
        $this->form_validation->set_rules('token', 'Token', 'trim|required');
        var_dump($this->input->post());
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Opps! Mohon maaf, gagal disimpan silakan untuk mencoba lagi.</div>');
            redirect('user');
        } else {
            $email = $this->session->userdata('email');
            $token = $this->input->post('token');
            $merchant_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($merchant_token) {
                if (time() - $merchant_token['date_created'] < (60 * 60 * 1)) {
                    // update merchant
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('merchant');
                    // set role_id jadi 2
                    $this->db->set('role_id', 2);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    // logout and
                    // update aktivitas user
                    $this->db->set('last_login', time());
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');
                    // unset
                    $this->session->unset_userdata('email');
                    $this->session->unset_userdata('role_id');
                    // delete user_token
                    $this->db->delete('user_token', ['token' => $token]);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sekarang Anda adalah penyedia jasa, silakan login kembali.</div>');
                    redirect('auth');
                } else {
                    $this->db->delete('user_token', ['token' => $token]);
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktivasi merchant gagal! token sudah expired.</div>');
                    redirect('user');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktivasi akun gagal! token tidak cocok.</div>');
                redirect('user');
            }
        }
    }
}
