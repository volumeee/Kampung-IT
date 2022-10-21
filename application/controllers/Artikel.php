<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Artikel extends CI_Controller
{
    public function index($slug = NULL)
    {
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $data['nav'] = "artikel";
        $this->load->model('Menu_model', 'menu');
        $data['frontendNav'] = $this->menu->showFrontendNav();
        if (isset($slug)) {
            $data['artikel'] = $this->db->get_where('artikel', ['link' => $slug])->row_array();
            $this->db->update('artikel', ['dilihat' => $data['artikel']['dilihat'] + 1], ['link' => $slug]);
            $this->load->view('artikel_detail', $data);
        } else {
            $data['artikel'] = $this->db->get('artikel')->result_array();
            $this->load->view('artikel', $data);
        }
    }
}
