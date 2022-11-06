<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Merchant_model extends CI_Model
{
    public function getChat($email_sender, $email_receiver)
    {
        $hasMerchant = $this->db->select('merchant_id')->get_where('merchant', ['email' => $email_receiver])->row_array();
        // prepare, if found then replace it
        $data = [];
        if ($hasMerchant) {
            // set all message status to 1
            $this->db->update('chat', ['status' => 1], ['sender_id' => $email_sender, 'receiver_id' => $hasMerchant['merchant_id'], 'identify' => $email_sender]);
            // get data chat
            $data = $this->db->order_by('datetime', 'DESC')->get_where('chat', ['sender_id' => $email_sender, 'receiver_id' => $hasMerchant['merchant_id']], 100)->result_array();
        }
        return $data;
    }

    public function getChats($email)
    {
        $hasMerchant = $this->db->select('merchant_id')->get_where('merchant', ['email' => $email])->row_array();
        // prepare, if found then replace it
        $data = [];
        if ($hasMerchant) {
            $chats = $this->db->select('user.name, user.image, user.email')->join('user', 'user.email = chat.sender_id')->group_by('chat.sender_id')->get_where('chat', ['receiver_id' => $hasMerchant['merchant_id']])->result_array();
            foreach ($chats as $c) {
                array_push($data, [
                    'name' => $c['name'],
                    'image' => $c['image'],
                    'email' => $c['email'],
                    'belum_dibaca' => $this->_countBelumDibaca($c['email'], $hasMerchant['merchant_id'])
                ]);
            }
        }
        return $data;
    }

    private function _countBelumDibaca($email_sender, $merchant_id)
    {
        $getData = $this->db->select('COUNT(status) AS belum_dibaca')->from('chat')->where(['status' => 0, 'sender_id' => $email_sender, 'receiver_id' => $merchant_id, 'identify !=' => $merchant_id])->get()->row_array();
        return $getData['belum_dibaca'];
    }

    public function showListPostingan()
    {
        $this->db->select('post.post_id, post.judul, post.banner, post.datetime, post.dilihat');
        $this->db->from('post');
        $this->db->where('post.email', $this->session->userdata('email'));
        $this->db->order_by('post.datetime', 'DESC');
        return $this->db->get()->result_array();
    }

    public function handlePostAction($post, $file = null)
    {
        if (base64_decode($post['tokenPost']) == 'posting') {
            // handle upload bannerArtikel
            $upload_image = $file['name'];
            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
                $config['max_size']     = '8192';
                $config['upload_path'] = './assets/img/post/';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('bannerArtikel')) {
                    $banner = $this->upload->data('file_name');
                } else {
                    $banner = NULL;
                }
            }
            // jika tidak ada foto gagalkan proses insert
            if ($banner != NULL) {
                // load admin model
                $this->load->model('Admin_model', 'admin');
                // masukkan ke variabel dulu, semua yang $this->input->post()
                $data = [
                    'post_id' => $this->admin->autoId('post', 'post_id', 'PST') . rand(0, 9),
                    'email' => $this->session->userdata('email'),
                    'judul' => htmlspecialchars($post['judulPost']),
                    'banner' => $banner,
                    'text' => $post['text'],
                    'tarif' => reset_rupiah($post['tarif']),
                    'datetime' => date('Y-m-d H:i:s', time()),
                    'dilihat' => 0
                ];
                $resp =  ($this->db->insert('post', $data)) ? 'ok' : 'errInsert';
            } else $resp = 'errFoto';
        } else if (base64_decode($post['tokenPost']) == 'edit') {
            // define upload status
            $banner = true;
            // get file gambar lama n baru
            if ($file['name'] != '' && $file['name'] != $post['bannerOldPost']) {
                // upload gambar baru bannerArtikel
                $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
                $config['max_size']     = '8192';
                $config['upload_path'] = './assets/img/post/';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('bannerArtikel')) {
                    $banner = $this->upload->data('file_name');
                    // hapus gambar lama
                    unlink($config['upload_path'] . $post['bannerOldPost']);
                    // inisial update
                    $data   = [
                        'judul' => htmlspecialchars($post['judulPost']),
                        'tarif' => reset_rupiah($post['tarif']),
                        'text' => $post['text'],
                        'banner' => $banner
                    ];
                } else $banner = false;
            } else {
                // gambar masih pakai yang lama, inisial update
                $data = [
                    'judul' => htmlspecialchars($post['judulPost']),
                    'tarif' => reset_rupiah($post['tarif']),
                    'text' => $post['text'],
                    'banner' => $post['bannerOldPost']
                ];
            }
            // jika upload berhasil update db
            if ($banner) {
                $this->db->set($data);
                $this->db->where('post_id', $post['post_id']);
                $resp = ($this->db->update('post')) ? 'ok' : 'err';
            } else $resp = 'errFoto';
        }
        return $resp;
    }
}
