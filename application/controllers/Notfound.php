<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notfound extends CI_Controller
{
    public function index()
    {
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $this->load->view('errors/notfound404', $data);
    }
}
