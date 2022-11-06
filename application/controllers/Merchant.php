<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Merchant extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'My Merchant';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $data['kategori'] = $this->db->get('kategori')->result_array();
        $data['merchant'] = $this->db->get_where('merchant', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->input->post('nama_usaha_old') != $this->input->post('nama_usaha'))
            $this->form_validation->set_rules('nama_usaha', 'nama bisnis', 'trim|required|is_unique[merchant.nama_usaha]', [
                'is_unique' => 'nama bisnis ini sudah terdaftar.'
            ]);
        else $this->form_validation->set_rules('nama_usaha', 'nama bisnis', 'trim|required');
        $this->form_validation->set_rules('kategori', 'kategori', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'deskripsi', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('merchant/index');
            $this->load->view('templates/footer');
        } else {
            $nama_usaha = htmlspecialchars($this->input->post('nama_usaha'));
            $email = $this->session->userdata('email');
            $kategori = htmlspecialchars($this->input->post('kategori'));
            $alamat = htmlspecialchars($this->input->post('alamat'));
            $deskripsi = htmlspecialchars($this->input->post('deskripsi'));
            if ($this->db->update('merchant', [
                'nama_usaha' => $nama_usaha,
                'email' => $email,
                'kategori' => $kategori,
                'alamat' => $alamat,
                'deskripsi' => $deskripsi
            ], [
                'email' => $email
            ])) $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil update merchant.</div>');
            else $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Opps! Mohon maaf, gagal disimpan silakan untuk mencoba lagi.</div>');
            redirect('merchant');
        }
    }

    public function posting()
    {
        $data['title'] = 'Posting';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $this->load->model('Merchant_model', 'merchant');
        $data['postingan'] = $this->merchant->showListPostingan();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('merchant/post', $data);
        $this->load->view('templates/footer');
    }

    public function postAction()
    {
        $data['title'] = 'Posting';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();

        // set form validation
        $this->form_validation->set_rules('judulPost', 'Judul post', 'required|trim');
        $this->form_validation->set_rules('text', 'Isi post', 'required|trim');
        $this->form_validation->set_rules('tarif', 'Tarif', 'required|trim');
        $this->form_validation->set_rules('tokenPost', 'Token post', 'required|trim');

        if ($this->form_validation->run() == false) {
            // jika ada segment ketiga brti edit post
            if ($this->uri->segment(3)) {
                $cekRow = $this->db->select('post_id')->from('post')->where('post_id', $this->uri->segment(3))->get()->num_rows();
                if ($cekRow == 0) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><strong>Periksa Post ID, mungkin sudah dihapus atau belum dibuat.</div>');
                    redirect('merchant/post');
                } else {
                    $data['postDetail'] = $this->db->get_where('post', ['post_id' => $this->uri->segment(3)])->row_array();
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('templates/topbar', $data);
                    $this->load->view('merchant/post-action', $data);
                    $this->load->view('templates/footer');
                }
            }
            // jika tidak ada segment ketiga berti add postingan
            else {
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('merchant/post-action', $data);
                $this->load->view('templates/footer');
            }
        } else {
            // insert to db
            $this->load->model('Merchant_model', 'merchant');
            // var_dump($this->merchant->handlePostAction($this->input->post(), $_FILES['bannerArtikel']));
            if ($this->merchant->handlePostAction($this->input->post(), $_FILES['bannerArtikel']) == 'ok') $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil menyimpan postingan.</div>');
            else $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menyimpan postingan.</div>');
            redirect('merchant/posting');
        }
    }

    public function deletePost($link)
    {
        $cariAsset = $this->db->select('banner')->get_where('post', ['post_id' => $link])->row_array();
        if (unlink('./assets/img/post/' . $cariAsset['banner'])) {
            // delete db
            $this->db->delete('post', ['post_id' => $link]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil hapus postingan.</div>');
        } else $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal hapus postingan.</div>');
        redirect('merchant/posting');
    }

    public function chat($email = NULL)
    {
        $data['title'] = 'Chat';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $this->load->model('Merchant_model', 'merchant');
        if ($email == null) {
            $data['chats'] = $this->merchant->getChats($this->session->userdata('email'));
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('merchant/chats', $data);
            $this->load->view('templates/footer');
        } else {
            $data['userChatting'] = $this->db->select('name, email')->get_where('user', ['email' => urldecode($email)])->row_array();
            $data['merchant'] = $this->db->select('merchant_id')->get_where('merchant', ['email' => $this->session->userdata('email')])->row_array();
            $data['chat'] = $this->merchant->getChat(urldecode($email), $this->session->userdata('email'));
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('merchant/chat-room', $data);
            $this->load->view('templates/footer');
        }
    }

    public function sendChat()
    {
        $pesan = htmlspecialchars($this->input->post('pesan'));
        $from = $this->input->post('sender_id');
        $to = $this->input->post('receiver_id');
        $datetime = date('Y-m-d H:i:s', time());
        $this->db->insert(
            'chat',
            [
                'sender_id' => $from,
                'receiver_id' => $to,
                'text' => $pesan,
                'status' => 0,
                'identify' => $to,
                'datetime' => $datetime
            ]
        );
        redirect('merchant/chat/' . urlencode($from));
    }

    public function deleteChat($sender_id)
    {
        $hasMerchant = $this->db->select('merchant_id')->get_where('merchant', ['email' => $this->session->userdata('email')])->row_array();
        $this->db->where(['sender_id' => $sender_id, 'receiver_id' => $hasMerchant['merchant_id']]);
        $this->db->delete('chat');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Chat has been deleted.</div>');
        redirect('merchant/chat');
    }
}
