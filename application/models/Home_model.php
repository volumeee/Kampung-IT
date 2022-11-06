<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_model extends CI_Model
{
    public function productForIndex()
    {
        return $this->db->select('post.post_id, post.judul, post.banner, post.tarif, merchant.alamat, merchant.nama_usaha')->join('merchant', 'post.email = merchant.email')->order_by('rand()')->get('post', 20)->result_array();
    }

    public function detailProduct($post_id)
    {
        return $this->db->select('post.post_id, post.judul, post.banner, post.tarif, post.dilihat, post.text, merchant.merchant_id, merchant.alamat, merchant.nama_usaha, user.image, kategori.kategori')->join('merchant', 'post.email = merchant.email')->join('user', 'post.email = user.email')->join('kategori', 'merchant.kategori = kategori.kategori_id')->get_where('post', ['post.post_id' => $post_id])->row_array();
    }

    public function otherProductsList($post_id)
    {
        return $this->db->select('post.post_id, post.judul, post.banner, post.tarif, merchant.alamat, merchant.nama_usaha')->join('merchant', 'post.email = merchant.email')->order_by('rand()')->get_where('post', ['post_id !=' => $post_id], 4)->result_array();
    }

    public function resultSearchRowCount($param)
    {
        $query = "SELECT post.post_id, post.judul, post.banner, post.tarif, post.text, merchant.alamat, merchant.nama_usaha, user.image, kategori.kategori FROM post JOIN merchant ON post.email = merchant.email JOIN user ON post.email = user.email JOIN kategori ON merchant.kategori = kategori.kategori_id WHERE merchant.alamat LIKE '%$param%' OR merchant.nama_usaha LIKE '%$param%' OR kategori.kategori LIKE '%$param%' OR post.judul LIKE '%$param%'";
        return $this->db->query($query)->num_rows();
    }
    public function resultSearch($param, $limit, $start)
    {
        $query = "SELECT post.post_id, post.judul, post.banner, post.tarif, post.text, merchant.alamat, merchant.nama_usaha, user.image, kategori.kategori FROM post JOIN merchant ON post.email = merchant.email JOIN user ON post.email = user.email JOIN kategori ON merchant.kategori = kategori.kategori_id WHERE merchant.alamat LIKE '%$param%' OR merchant.nama_usaha LIKE '%$param%' OR kategori.kategori LIKE '%$param%' OR post.judul LIKE '%$param%' LIMIT $limit, $start";
        return $this->db->query($query)->result_array();
    }
}
