<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Menu User';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->load->model('Admin_model', 'admin');
        $data['menuAllUser'] = $this->admin->showAllMenuUser();

        $this->form_validation->set_rules('menu', 'Menu', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil menambahkan menu baru.</div>');
            redirect('menu');
        }
    }

    public function deleteMenu($id_menu)
    {
        $this->db->where('id', $id_menu);
        $this->db->delete('user_menu');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil menghapus menu.</div>');
        redirect('menu');
    }

    public function submenu()
    {
        $this->load->model('Menu_model', 'menu');
        $data['title'] = 'Submenu User';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->form_validation->set_rules('judul', 'Nama submenu', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Url', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('judul'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><strong>' . $data['title'] . '</strong> telah ditambahkan ke Submenu.</div>');
            redirect('menu/submenu');
        }
    }

    public function editSubMenu($id_submenu)
    {
        $this->load->model('Menu_model', 'menu');
        $data['title'] = 'Submenu User';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['menuName'] = $this->menu->getMenuName($id_submenu);
        $data['submenu'] = $this->db->get_where('user_sub_menu', ['id' => $id_submenu])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/edit-submenu', $data);
        $this->load->view('templates/footer');
    }

    public function updateSubMenu()
    {
        $id = $this->input->post('id');
        $data = [
            'menu_id' => $this->input->post('menu_id'),
            'title' => $this->input->post('judul'),
            'url' => $this->input->post('url'),
            'icon' => $this->input->post('icon'),
            'is_active' => $this->input->post('is_active')
        ];
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('user_sub_menu');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu has been updates.</div>');
        redirect('menu/submenu');
    }

    public function deleteSubMenu($id_submenu)
    {
        $this->db->where('id', $id_submenu);
        $this->db->delete('user_sub_menu');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu has been deleted.</div>');
        redirect('menu/submenu');
    }

    public function frontendNav()
    {
        $this->load->model('Menu_model', 'menu');
        $data['title'] = 'Frontend Navbar';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $data['menu'] = $this->db->get('menu_front')->result_array();
        $data['submenu'] = $this->menu->showListSubmenuFrontend();
        $data['frontendNav'] = $this->menu->showFrontendNav();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/frontendNav', $data);
        $this->load->view('templates/footer');
    }

    public function menuFrontendAction()
    {
        $this->load->model('Menu_model', 'menu');
        switch (base64_decode($this->input->post('token'))) {
            case 'addMenuFe':
                $this->form_validation->set_rules('titleMenuFe', 'Title menu', 'required|trim|is_unique[menu_front.title]', [
                    'is_unique' => 'Title ini sudah terdaftar.'
                ]);
                $this->form_validation->set_rules('urlMenuFe', 'URL tujuan', 'required|trim');
                $this->form_validation->set_rules('isActiveMenuFe', 'Is active', 'required|trim');
                $this->form_validation->set_rules('token', 'token', 'required|trim');
                break;
            case 'addSubmenuFe':
                $this->form_validation->set_rules('parent_idSubmenuFe', 'Parent menu', 'required|trim');
                $this->form_validation->set_rules('titleSubmenuFe', 'Title menu', 'required|trim|is_unique[menu_front_detail.title]', [
                    'is_unique' => 'Title ini sudah terdaftar.'
                ]);
                $this->form_validation->set_rules('urlSubmenuFe', 'URL tujuan', 'required|trim');
                $this->form_validation->set_rules('isActiveSubmenuFe', 'Is active', 'required|trim');
                $this->form_validation->set_rules('token', 'token', 'required|trim');
                break;
            case 'editMenuFe':
                if ($this->input->post('titleMenuFeEdit') != $this->input->post('hiddenTitleMfOld')) $this->form_validation->set_rules('titleMenuFeEdit', 'Title menu', 'required|trim|is_unique[menu_front.title]', [
                    'is_unique' => 'Title ini sudah terdaftar.'
                ]);
                else $this->form_validation->set_rules('titleMenuFeEdit', 'Title menu', 'required|trim');
                $this->form_validation->set_rules('urlMenuFeEdit', 'URL tujuan', 'required|trim');
                $this->form_validation->set_rules('isActiveMenuFeEdit', 'Is active', 'required|trim');
                $this->form_validation->set_rules('token', 'token', 'required|trim');
                $this->form_validation->set_rules('hiddenMfId', 'Id Menu Frontend', 'required|trim');
                break;
            case 'editSubmenuFe':
                $this->form_validation->set_rules('parent_idSubmenuFeEdit', 'Parent menu', 'required|trim');
                if ($this->input->post('titleSubmenuFeEdit') != $this->input->post('hiddenTitleMfdOld')) $this->form_validation->set_rules('titleSubmenuFeEdit', 'Title menu', 'required|trim|is_unique[menu_front.title]', [
                    'is_unique' => 'Title ini sudah terdaftar.'
                ]);
                else $this->form_validation->set_rules('titleSubmenuFeEdit', 'Title menu', 'required|trim');
                $this->form_validation->set_rules('urlSubmenuFeEdit', 'URL tujuan', 'required|trim');
                $this->form_validation->set_rules('isActiveSubmenuFeEdit', 'Is active', 'required|trim');
                $this->form_validation->set_rules('token', 'token', 'required|trim');
                $this->form_validation->set_rules('hiddenMfdId', 'Id Submenu frontend', 'required|trim');
                break;
        }
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menyimpan data, periksa semua inputan apaah sudah terisi dengan benar.</div>');
            redirect('menu/frontendnav');
        } else {
            if ($this->menu->handleMenuFrontendAction($this->input->post()) == 'ok') $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil menyimpan data.</div>');
            else  $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal menyimpan data, database error.</div>');
        }
        redirect('menu/frontendnav');
    }

    public function deleteMenuFe($mf_id)
    {
        $this->db->where('mf_id', $mf_id);
        $this->db->delete('menu_front');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu frontend has been deleted.</div>');
        redirect('menu/frontendnav');
    }

    public function deleteSubmenuFe($mfd_id)
    {
        $this->db->where('mfd_id', $mfd_id);
        $this->db->delete('menu_front_detail');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu has been deleted.</div>');
        redirect('menu/frontendnav');
    }
}
