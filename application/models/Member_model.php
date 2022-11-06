<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member_model extends CI_Model
{
    public function getChats()
    {
        $chats = $this->db->select('merchant.nama_usaha, merchant.merchant_id, user.image')->join('merchant', 'merchant.merchant_id = chat.receiver_id')->join('user', 'user.email = merchant.email')->group_by('chat.receiver_id')->get_where('chat', ['sender_id' => $this->session->userdata('email')])->result_array();
        $data = [];
        foreach ($chats as $c) {
            array_push($data, [
                'nama_usaha' => $c['nama_usaha'],
                'merchant_id' => $c['merchant_id'],
                'image' => $c['image'],
                'belum_dibaca' => $this->_countBelumDibaca($c['merchant_id'])
            ]);
        }
        return $data;
    }

    private function _countBelumDibaca($id)
    {
        $getData = $this->db->select('COUNT(status) AS belum_dibaca')->from('chat')->where(['status' => 0, 'sender_id' => $this->session->userdata('email'), 'receiver_id' => $id, 'identify !=' => $this->session->userdata('email')])->get()->row_array();
        return $getData['belum_dibaca'];
    }
}
