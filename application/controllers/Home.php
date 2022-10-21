<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'Home - Kampung IT';
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $data['kategori'] = $this->db->select('kategori')->get('kategori')->result_array();
        $data['carousel'] = $this->db->select('link, judul, banner')->get('artikel', 3)->result_array();
        $this->load->model('Home_model', 'home');
        $data['products'] = $this->home->productForIndex();
        $this->load->view('templates/f_header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('templates/f_footer', $data);
    }

    public function contact()
    {
        $data['title'] = 'Contact - Kampung IT';
        $data['identitas'] = $this->db->get('identitas')->row_array();

        $this->form_validation->set_rules('nama', 'nama', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
        $this->form_validation->set_rules('message', 'pesan', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/f_header', $data);
            $this->load->view('home/contact');
            $this->load->view('templates/f_footer', $data);
        } else {
            $this->load->model('Admin_model', 'admin');
            $inbox_id = $this->admin->autoId('inbox', 'inbox_id', 'IBX');
            $nama = htmlspecialchars($this->input->post('nama'));
            $email = htmlspecialchars($this->input->post('email'));
            $pesan = htmlspecialchars($this->input->post('message'));
            $datetime = date('Y-m-d H:i:s', time());
            if ($this->db->insert('inbox', [
                'inbox_id' => $inbox_id,
                'nama' => $nama,
                'email' => $email,
                'pesan' => $pesan,
                'datetime' => $datetime
            ])) $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pesan Anda berhasil disimpan, terima kasih.</div>');
            else $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Opps! Mohon maaf, pesan Anda gagal disimpan silakan untuk mencoba lagi.</div>');
            redirect('home/contact');
        }
    }

    public function artikel($slug = NULL)
    {
        $data['identitas'] = $this->db->get('identitas')->row_array();
        if (isset($slug)) {
            $data['artikel'] = $this->db->get_where('artikel', ['link' => $slug])->row_array();
            $data['title'] = $data['artikel']['judul'] . ' - Kampung IT';
            $this->db->update('artikel', ['dilihat' => $data['artikel']['dilihat'] + 1], ['link' => $slug]);
            $this->load->view('templates/f_header', $data);
            $this->load->view('home/artikel_detail', $data);
            $this->load->view('templates/f_footer', $data);
        } else {
            $data['artikel'] = $this->db->get('artikel')->result_array();
            $data['title'] = 'Artikel - Kampung IT';
            $this->load->view('templates/f_header', $data);
            $this->load->view('home/artikel', $data);
            $this->load->view('templates/f_footer', $data);
        }
    }

    public function product($post_id = NULL)
    {
        if (!$post_id) redirect('notfound');
        else {
            $this->load->model('Home_model', 'home');
            $data['product'] = $this->home->detailProduct($post_id);
            if (!$data['product']) redirect('notfound');
            else {
                $data['title'] = $data['product']['judul'] . ' - Kampung IT';
                $data['identitas'] = $this->db->get('identitas')->row_array();
                // other products
                $data['others'] = $this->home->otherProductsList($post_id);
                $this->db->select()->get_where('post', ['post_id !=' => $post_id], 4)->result_array();
                // update dilihat
                $this->db->update('post', ['dilihat' => $data['product']['dilihat'] + 1], ['post_id' => $post_id]);
                // load template
                $this->load->view('templates/f_header', $data);
                $this->load->view('home/product-detail', $data);
                $this->load->view('templates/f_footer', $data);
            }
        }
    }

    public function search($param = NULL)
    {
        if (!$param) redirect('notfound');
        else {
            $param = htmlspecialchars(urldecode($param));
            //load libary pagination
            $this->load->library('pagination');
            // load model
            $this->load->model('Home_model', 'home');
            // $this->home->resultSearch($param, $start, $limit);
            //konfigurasi pagination
            $config['per_page'] = 10;  //show record per halaman
            $config['base_url'] = site_url("search/$param/index"); //site url
            $config['total_rows'] = $this->home->resultSearchRowCount($param); //total row
            $config['uri_segment'] = 4;  // uri parameter
            $choice = $config['total_rows'] / $config['per_page'];
            $config['num_links'] = floor($choice);
            $this->pagination->initialize($config);
            // lempar data ke view
            $data['title'] = 'Results "' . $param . '"' . ' - Kampung IT';
            $data['identitas'] = $this->db->get('identitas')->row_array();
            $data['totalPages'] = $config['num_links'];
            $data['totalFound'] = $config['total_rows'];
            $data['pageNow'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
            $data['results'] = $this->home->resultSearch($param, $data['pageNow'] - 1, $config['per_page']);
            $data['kategori'] = $this->db->select('kategori')->get('kategori')->result_array();
            //load template
            $this->load->view('templates/f_header', $data);
            $this->load->view('home/search', $data);
            $this->load->view('templates/f_footer', $data);
        }
    }

    public function searchNav()
    {
        redirect('home/search/' . $this->input->post('search'));
    }
}
