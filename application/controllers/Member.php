<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Chat';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $this->load->model('Member_model', 'member');
        $data['chats'] = $this->member->getChats();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('member/chats', $data);
        $this->load->view('templates/footer');
    }

    public function chat($merchant_id)
    {
        $data['title'] = 'Chat';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $data['merchant'] = $this->db->select('merchant_id, nama_usaha')->get_where('merchant', ['merchant_id' => $merchant_id])->row_array();
        // set all message status to 1
        $this->db->update('chat', ['status' => 1], ['sender_id' => $this->session->userdata('email'), 'receiver_id' => $merchant_id, 'identify' => $merchant_id]);
        // get data chat
        $data['chat'] = $this->db->order_by('datetime', 'DESC')->get_where('chat', ['sender_id' => $this->session->userdata('email'), 'receiver_id' => $merchant_id], 100)->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('member/chat-room', $data);
        $this->load->view('templates/footer');
    }

    public function sendChat()
    {
        $pesan = htmlspecialchars($this->input->post('pesan'));
        $from = $this->session->userdata('email');
        $to = $this->input->post('receiver_id');
        $datetime = date('Y-m-d H:i:s', time());
        $this->db->insert(
            'chat',
            [
                'sender_id' => $from,
                'receiver_id' => $to,
                'text' => $pesan,
                'status' => 0,
                'identify' => $from,
                'datetime' => $datetime
            ]
        );
        redirect('member/chat/' . $to);
    }

    public function deleteChat($merchant_id)
    {
        $this->db->where(['sender_id' => $this->session->userdata('email'), 'receiver_id' => $merchant_id]);
        $this->db->delete('chat');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Chat has been deleted.</div>');
        redirect('member');
    }

    public function historyRate()
    {
        $data['title'] = 'History Rate';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['identitas'] = $this->db->get('identitas')->row_array();
        $data['rate'] = $this->db->select('review.review_id, review.user_review, post.judul, post.banner, post.post_id')->join('post', 'post.post_id = review.post_id')->get_where('review', ['review.email' => $this->session->userdata('email')])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('member/rate', $data);
        $this->load->view('templates/footer');
    }

    public function updateReview()
    {
        $this->db->set('user_review', htmlspecialchars($this->input->post('inputEditReview')));
        $this->db->where('review_id', $this->input->post('inputIdReview'));
        $this->db->update('review');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Review has been updates.</div>');
        redirect('member/historyrate');
    }

    public function deleteReview($review_id)
    {
        $this->db->where('review_id', $review_id);
        $this->db->delete('review');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Review has been deleted.</div>');
        redirect('member/historyrate');
    }

    public function cekPesanSekarang()
    {
        $linkProduct = $this->input->post('link_reff');
        $titleProduct = $this->input->post('title_reff');
        $imageProduct = $this->input->post('img_reff');
        $merchant_id = $this->input->post('merchant_id');
        $from = $this->session->userdata('email');
        $datetime = date('Y-m-d H:i:s', time());
        $this->db->insert(
            'chat',
            [
                'sender_id' => $from,
                'receiver_id' => $merchant_id,
                'text' => '<div class="row"><div class="col-lg-3 mb-2 mb-md-0 text-center"><img src="' . base_url('assets/img/post/') . $imageProduct . '" class="img-fluid img-thumbnail" alt="' . $titleProduct . '" style="height: 68px; width: 80px;"></div><div class="col-lg-9 my-auto ml-md-n2"><a href="' . $linkProduct . '" target="_blank" class="text-white text-decoration-none font-weight-bold font-italic" title="Klik untuk melihat produk"><i class="fas fa-paperclip fa-xs"></i> ' . $titleProduct . '</a></div></div><p class="mt-2">Halo kak, apakah produk ini tersedia ?</p>',
                'status' => 0,
                'identify' => $from,
                'datetime' => $datetime
            ]
        );
        redirect('member/chat/' . $merchant_id);
    }
}
