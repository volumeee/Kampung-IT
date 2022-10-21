<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $this->load->model('Admin_model', 'admin');
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $this->load->model('Admin_model', 'admin');
        $data['lastLogin'] = $this->admin->userLastLogin();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();

        // load semua role
        $data['role'] = $this->db->get('user_role')->result_array();
        // load semua user bersta rolenya
        $this->load->model('User_model', 'user');
        $data['userWithRole'] = $this->user->getUserWithRole();
        $data['countUserRole'] = $this->user->countUserRole();

        $this->form_validation->set_rules('role', 'Role', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'role' => htmlspecialchars($this->input->post('role'))
            ];

            $this->db->insert('user_role', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>' . $data['role'] . '</strong> berhasil ditambahkan ke role.</div>');
            redirect('admin/role');
        }
    }

    public function updateRole()
    {
        $this->form_validation->set_rules('inputEditRole', 'Nama role', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal update role.</div>');
            redirect('admin/role');
        } else {
            $id = $this->input->post('inputIdRole');
            $role = htmlspecialchars($this->input->post('inputEditRole'));

            $this->db->set('role', $role);
            $this->db->where('id', $id);
            $this->db->update('user_role');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role has been updates.</div>');
            redirect('admin/role');
        }
    }

    public function deleteRole($id_role)
    {
        $this->db->where('id', $id_role);
        $this->db->delete('user_role');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role has been deleted.</div>');
        redirect('admin/role');
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
        // menu_id
        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');
        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];
        $result = $this->db->get_where('user_access_menu', $data);
        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access changed.</div>');
    }

    public function addUser()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email sudah ada.'
        ]);
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]', [
            'is_unique' => 'Username sudah ada.'
        ]);
        $this->form_validation->set_rules('fullname', 'Fullname', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
            'min_length' => 'Password terlalu pendek, min. 3 karakter'
        ]);

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal input user baru.</div>');
            redirect('admin/role');
        } else {
            $role_id = htmlspecialchars($this->input->post('role_id', true));
            $email = htmlspecialchars($this->input->post('email', true));
            $username = htmlspecialchars($this->input->post('username', true));
            $fullname = htmlspecialchars($this->input->post('fullname', true));
            $data = [
                'email' => $email,
                'username' => $username,
                'name' => $fullname,
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => $role_id,
                'is_active' => 1,
                'date_created' => time()
            ];
            $this->db->insert('user', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>' . $data['username'] . '</strong> ditambahkan ke user.</div>');
            redirect('admin/role');
        }
    }

    public function updateUser()
    {
        if ($this->input->post('hiddenInputUsername') != trim($this->input->post('inputEditUsername'))) $this->form_validation->set_rules('inputEditUsername', 'Username', 'required|trim|is_unique[user.username]', [
            'is_unique' => 'Username sudah terdaftar.'
        ]);
        if ($this->input->post('hiddenInputEmail') != trim($this->input->post('inputEditEmail'))) $this->form_validation->set_rules('inputEditEmail', 'Email', 'required|trim|is_unique[user.email]', [
            'is_unique' => 'Email sudah terdaftar.'
        ]);
        if ($this->input->post('inputEditPassword')) $this->form_validation->set_rules('inputEditPassword', 'Password', 'required|trim');
        $this->form_validation->set_rules('inputEditFullname', 'Fullname', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal edit user.</div>');
        } else {
            $role_id = $this->input->post('inputEditRoleUser');
            $emailNew = htmlspecialchars($this->input->post('inputEditEmail', true));
            $emailOld = $this->input->post('hiddenInputEmail');
            $usernameNew = htmlspecialchars($this->input->post('inputEditUsername', true));
            $fullname = htmlspecialchars($this->input->post('inputEditFullname', true));
            // cek apakah ada field inputEditPassword
            ($this->input->post('inputEditPassword')) ? $withChangePass = true : $withChangePass = false;
            if ($withChangePass) {
                // jika terdapat password baru
                $data = [
                    'email' => $emailNew,
                    'username' => $usernameNew,
                    'name' => $fullname,
                    'role_id' => $role_id,
                    'password' => password_hash($this->input->post('inputEditPassword'), PASSWORD_DEFAULT)
                ];
            } else {
                // jika tidak ada password baru
                $data = [
                    'email' => $emailNew,
                    'username' => $usernameNew,
                    'name' => $fullname,
                    'role_id' => $role_id
                ];
            }
            // ekse update user
            $this->db->set($data);
            $this->db->where('email', $emailOld);
            // update db dan tampilkan notif
            if ($this->db->update('user')) $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User <strong>' . $usernameNew . '</strong> telah diperbarui.</div>');
            else $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Terjadi kesalahan dalam menyimpan data, gagal edit user.</div>');
        }
        redirect('admin/role');
    }

    public function deleteUser($email)
    {
        $this->db->where('email', $email);
        $this->db->delete('user');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>' . $email . '</strong> dihapus dari user.</div>');
        redirect('admin/role');
    }

    public function identitas()
    {
        $data['title'] = 'Identitas';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();

        $this->form_validation->set_rules('typePost', 'Type postingan', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/identitas', $data);
            $this->load->view('templates/footer');
        } else {
            $type = base64_decode($this->input->post('typePost'));
            switch ($type) {
                case 'umum':
                    $nama = htmlspecialchars($this->input->post('namaInstansi'));
                    $alamat = htmlspecialchars($this->input->post('alamat'));
                    $no_telp = htmlspecialchars($this->input->post('noTelp'));
                    $email = htmlspecialchars($this->input->post('email'));
                    $deskripsi = htmlspecialchars($this->input->post('deskripsi'));
                    // for logo
                    if ($_FILES['logoInstansi']['name']) {
                        $config['allowed_types'] = 'ico|jpg|jpeg|png|webp';
                        $config['max_size']     = '8192'; //in KB
                        $config['upload_path'] = './assets/img/logo/';
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('logoInstansi')) {
                            if ($this->input->post('logoOld') != '' || $this->upload->data('file_name') != $this->input->post('logoOld')) unlink(FCPATH . 'assets/img/logo/' . $this->input->post('logoOld'));
                        }
                    }
                    $this->db->set('logo', ($_FILES['logoInstansi']['name']) ? $this->upload->data('file_name') : $this->input->post('logoOld'));
                    $this->db->set('nama_instansi', $nama);
                    $this->db->set('alamat', $alamat);
                    $this->db->set('no_telp', $no_telp);
                    $this->db->set('email', $email);
                    $this->db->set('deskripsi', $deskripsi);
                    $this->db->where('id_iden', 1);
                    if ($this->db->update('identitas')) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Berhasil memperbarui identitas.</div>');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><strong>Gagal memperbarui identitas.</div>');
                    }
                    break;
                case 'favicon':
                    $config['allowed_types'] = 'ico|jpg|jpeg|png|webp';
                    $config['max_size']     = '2048'; //in KB
                    $config['upload_path'] = './assets/img/favicon/';

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('faviconOrganisasi')) {
                        $old_image = $data['identitas']['favicon'];
                        if ($old_image != 'default.ico') {
                            unlink(FCPATH . 'assets/img/favicon/' . $old_image);
                        }
                        $new_image = $this->upload->data('file_name');
                        $this->db->set('favicon', $new_image);
                        $this->db->where('id_iden', 1);
                        $this->db->update('identitas');
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil mengganti favicon.</div>');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops! Maaf, tidak dapat mengganti favicon. Silakan coba lagi nanti ya.</div>');
                    }
                    break;
                case 'icon':
                    $icon = htmlspecialchars($this->input->post('iconOrganisasi'));
                    $this->db->set('icon', $icon);
                    $this->db->where('id_iden', 1);
                    if ($this->db->update('identitas')) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil memperbarui icon.</div>');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><strong>Gagal memperbarui icon.</div>');
                    }
                    break;
                case 'defaultFavicon':
                    $old_image = $data['identitas']['favicon'];
                    if ($old_image != 'default.ico') {
                        unlink(FCPATH . 'assets/img/favicon/' . $old_image);
                    }
                    $this->db->set('favicon', 'default.ico');
                    $this->db->where('id_iden', 1);
                    if ($this->db->update('identitas')) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil reset favicon ke default.</div>');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><strong>Gagal reset favicon.</div>');
                    }
                    break;
                case 'defaultIcon':
                    $this->db->set('icon', 'briefcase');
                    $this->db->where('id_iden', 1);
                    if ($this->db->update('identitas')) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Berhasil reset icon.</div>');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><strong>Gagal memperbarui icon.</div>');
                    }
                    break;
                case 'deleteLogo':
                    if (unlink(FCPATH . 'assets/img/logo/' . $this->input->post('logoOld'))) {
                        $this->db->set('logo', '');
                        $this->db->where('id_iden', 1);
                        if ($this->db->update('identitas')) $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil hapus logo, coba llagi nantit.</div>');
                        else $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><strong>Gagal hapus logo, coba llagi nanti.</div>');
                    } else $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><strong>Gagal hapus logo, coba llagi nanti.</div>');
                    break;
            }
            redirect('admin/identitas');
        }
    }

    public function artikel()
    {
        $data['title'] = 'Artikel';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $this->load->model('Admin_model', 'admin');
        $data['artikel'] = $this->admin->showListArtikel();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/artikel', $data);
        $this->load->view('templates/footer');
    }

    public function artikelAction()
    {
        $data['title'] = 'Artikel';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();
        // set form validation
        $this->form_validation->set_rules('judulArtikel', 'Judul artikel', 'required|trim');
        if ($this->input->post('LinkUrlSlugOldArtikel') == null)
            $this->form_validation->set_rules('linkUrlSlug', 'URL Slug artikel', 'required|trim|max_length[150]|is_unique[artikel.link]', [
                'is_unique' => 'Link sudah pernah dipakai',
                'max_length' => 'Link terlalu panjang, max. 150 karakter'
            ]);
        else if ($this->input->post('linkUrlSlug') == $this->input->post('LinkUrlSlugOldArtikel')) $this->form_validation->set_rules('linkUrlSlug', 'URL Slug artikel', 'required|trim');
        $this->form_validation->set_rules('isiArtikel', 'Isi artikel', 'required|trim');
        $this->form_validation->set_rules('tokenArtikel', 'Token artikel', 'required|trim');
        if ($this->form_validation->run() == false) {
            // jika ada segment ketiga brti edit artikel
            if ($this->uri->segment(3)) {
                $cekRow = $this->db->select('link')->from('artikel')->where('link', $this->uri->segment(3))->get()->num_rows();
                if ($cekRow == 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><strong>Periksa slug url artikel, mungkin sudah dihapus atau belum dibuat.</div>');
                    redirect('admin/artikel');
                } else {
                    $data['artikelDetail'] = $this->db->get_where('artikel', ['link' => $this->uri->segment(3)])->row_array();
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('templates/topbar', $data);
                    $this->load->view('admin/artikel-action', $data);
                    $this->load->view('templates/footer');
                }
            }
            // jika tidak ada segment ketiga berti add artikel
            else {
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('admin/artikel-action', $data);
                $this->load->view('templates/footer');
            }
        } else {
            // insert to db
            $this->load->model('Admin_model', 'admin');
            // var_dump($this->admin->handleArtikelAction($this->input->post(), $_FILES['bannerArtikel']));
            if ($this->admin->handleArtikelAction($this->input->post(), $_FILES['bannerArtikel']) == 'ok') $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil menyimpan artikel.</div>');
            else $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menyimpan artikel.</div>');
            redirect('admin/artikel');
        }
    }

    public function isLinkAvailable()
    {
        $this->load->model('Admin_model', 'admin');
        echo $this->admin->cekRowLinkArtikel($this->input->post('linkSlug'));
    }

    public function deleteArtikel($link)
    {
        $cariAsset = $this->db->select('banner')->get_where('artikel', ['link' => $link])->row_array();
        if (unlink('./assets/img/artikel/' . $cariAsset['banner'])) {
            // delete db
            $this->db->delete('artikel', ['link' => $link]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil hapus artikel.</div>');
        } else $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal hapus artikel.</div>');
        redirect('admin/artikel');
    }

    public function kategori()
    {
        $data['title'] = 'Kategori';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $data['kategori'] = $this->db->get('kategori')->result_array();
        // set form validation
        $this->form_validation->set_rules('kategori', 'Kategori', 'trim|required|is_unique[kategori.kategori]', [
            'is_unique' => 'Program ini sudah terdaftar.'
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/kategori', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'kategori' => htmlspecialchars($this->input->post('kategori'))
            ];
            $this->db->insert('kategori', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>' . $data['kategori'] . '</strong> berhasil ditambahkan.</div>');
            redirect('admin/kategori');
        }
    }

    public function updateKategori()
    {
        $this->form_validation->set_rules('inputEditProgram', 'Nama program', 'trim|required|is_unique[program.nama_program]', [
            'is_unique' => 'Program ini sudah terdaftar.'
        ]);
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal update program.</div>');
            redirect('admin/program');
        } else {
            $this->db->set('nama_program', htmlspecialchars($this->input->post('inputEditProgram')));
            $this->db->where('id_program', $this->input->post('inputIdProgram'));
            $this->db->update('program');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Program has been updates.</div>');
            redirect('admin/program');
        }
    }

    public function deleteKategori($id_program)
    {
        $this->db->where('id_program', $id_program);
        $this->db->delete('program');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role has been deleted.</div>');
        redirect('admin/program');
    }



    public function downloadBackupDb()
    {
        $this->load->dbutil();
        $dateNow = date('d', time()) . month(date('n', time()), 'mmm') . date('Y', time()) . '-' . date('His', time());
        $filename = 'DbKampungIt-' . $dateNow;
        $config = array(
            'format' => 'zip',
            'filename' => $filename . '.sql',
            'add_drop' => true,
            'add_insert' => true,
            'newline' => "\n",
            'foreign_key_checks' => false
        );
        $backup = $this->dbutil->backup($config);
        $namaFile = $filename . '.zip';
        $this->load->helper('download');
        force_download($namaFile, $backup);
    }

    public function restoreDb()
    {
        $this->load->model('Admin_model', 'admin');
        // file input
        $fileInput = $_FILES['restoreDbFile'];
        $nama = $_FILES['restoreDbFile']['name'];
        if (isset($fileInput)) {
            if (substr($nama, -3) == 'sql') {
                // lanjut restore
                $lokasiFile = $fileInput['tmp_name'];
                $direktori = "./assets/restoreTmp/$nama";
                move_uploaded_file($lokasiFile, "$direktori");
                // hapus semua table yg ada
                $this->admin->restoreDb();
                // restore db
                $isiFile = file_get_contents($direktori);
                $stringQuery = rtrim($isiFile, "\n;");
                $arrayQuery = explode(";", $stringQuery);
                foreach ($arrayQuery as $query) {
                    $this->db->query($query);
                }
                unlink($direktori);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil restore database <strong> ' . $nama . '</strong></div>');
            } else {
                // gagalkan
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Oops! file yang Anda upload bukan <strong>"DbApotek-TglBlnThn-UniqueTime.sql"</strong> atau yang berekstensi <strong>.sql</strong></div>');
            }
        }
        redirect('admin/settings');
    }

    public function inbox()
    {
        $data['title'] = 'Inbox';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/body-kosong', $data);
        $this->load->view('templates/footer');
    }
}
