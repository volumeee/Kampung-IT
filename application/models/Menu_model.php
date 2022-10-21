<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getSubMenu()
    {
        $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                    FROM `user_sub_menu` JOIN `user_menu`
                      ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                ORDER BY `user_menu`.`menu` ASC
                ";
        return $this->db->query($query)->result_array();
    }

    public function getMenuName($id_submenu)
    {
        $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                    FROM `user_sub_menu` JOIN `user_menu`
                      ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                   WHERE `user_sub_menu`.`id` = $id_submenu
                ";
        return $this->db->query($query)->row_array();
    }

    public function showListSubmenuFrontend()
    {
        $this->db->select('menu_front_detail.*, menu_front.title AS parent_menu');
        $this->db->from('menu_front_detail');
        $this->db->join('menu_front', 'menu_front.mf_id = menu_front_detail.parent_id');
        return $this->db->get()->result_array();
    }

    public function handleMenuFrontendAction($post)
    {
        switch (base64_decode($post['token'])) {
            case 'addMenuFe':
                if ($this->db->insert('menu_front', [
                    'title' => $post['titleMenuFe'],
                    'url' => $post['urlMenuFe'],
                    'is_active' => $post['isActiveMenuFe']
                ])) {
                    $resp = 'ok';
                } else $resp = 'err';
                break;
            case 'addSubmenuFe':
                if ($this->db->insert('menu_front_detail', [
                    'parent_id' => $post['parent_idSubmenuFe'],
                    'title' => $post['titleSubmenuFe'],
                    'url' => $post['urlSubmenuFe'],
                    'is_active' => $post['isActiveSubmenuFe']
                ])) {
                    $resp = 'ok';
                } else $resp = 'err';
                break;
            case 'editMenuFe':
                $this->db->set([
                    'title' => $post['titleMenuFeEdit'],
                    'url' => $post['urlMenuFeEdit'],
                    'is_active' => $post['isActiveMenuFeEdit']
                ]);
                $this->db->where('mf_id', $post['hiddenMfId']);
                if ($this->db->update('menu_front')) $resp = 'ok';
                else $resp = 'err';
                break;
            case 'editSubmenuFe':
                $this->db->set([
                    'parent_id' => $post['parent_idSubmenuFeEdit'],
                    'title' => $post['titleSubmenuFeEdit'],
                    'url' => $post['urlSubmenuFeEdit'],
                    'is_active' => $post['isActiveSubmenuFeEdit']
                ]);
                $this->db->where('mfd_id', $post['hiddenMfdId']);
                if ($this->db->update('menu_front_detail')) $resp = 'ok';
                else $resp = 'err';
                break;
        }
        return $resp;
    }

    public function showFrontendNav()
    {
        if ($this->db->select('mf_id, title, url')->from('menu_front')->where('is_active', 1)->get()->num_rows() == 0) $data = [];
        else $menu = $this->db->select('mf_id, title, url')->from('menu_front')->where('is_active', 1)->get()->result_array();
        $data = ['menu' => array()];
        foreach ($menu as $m) {
            $addMenu = [
                'title_menu' => $m['title'],
                'url_menu' => $m['url'],
                'submenu' => $this->_getSubmenuFrontend($m['mf_id'])
            ];
            array_push($data['menu'], $addMenu);
        }
        return $data;
    }

    private function _getSubmenuFrontend($mf_id)
    {
        return $this->db->select('title AS title_submenu, url AS url_submenu')->from('menu_front_detail')->where(['parent_id' => $mf_id, 'is_active' => 1])->get()->result_array();
    }
}
